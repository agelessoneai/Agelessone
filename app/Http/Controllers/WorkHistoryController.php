<?php

namespace App\Http\Controllers;

use App\Models\WorkerAttendance;
use App\Models\WorkSite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WorkHistoryController extends Controller
{
    public function index()
    {
        $sites = WorkSite::with(['supervisor'])
            ->withCount(['workerAttendances as attendance_records_count'])
            ->withSum('workerAttendances as total_working_minutes', 'working_minutes')
            ->orderBy('site_name')
            ->get();

        return view('admin.work_history.index', compact('sites'));
    }

    public function show(Request $request, WorkSite $workSite)
    {
        [$from, $to] = $this->validatedDates($request);
        $query = $this->recordsQuery($workSite, $from, $to);

        $summaryQuery = clone $query;
        $totalWorkers = (clone $summaryQuery)->distinct('worker_id')->count('worker_id');
        $totalMinutes = (int) (clone $summaryQuery)->sum('working_minutes');
        $completedShifts = (clone $summaryQuery)->whereNotNull('punch_out')->count();
        $openShifts = (clone $summaryQuery)->whereNull('punch_out')->count();

        $records = $query
            ->latest('attendance_date')
            ->latest('punch_in')
            ->paginate(30)
            ->withQueryString();

        $workSite->load(['supervisor', 'security']);

        return view('admin.work_history.show', compact(
            'workSite', 'records', 'from', 'to', 'totalWorkers',
            'totalMinutes', 'completedShifts', 'openShifts'
        ));
    }

    public function export(Request $request, WorkSite $workSite): StreamedResponse
    {
        [$from, $to] = $this->validatedDates($request);
        $records = $this->recordsQuery($workSite, $from, $to)
            ->orderBy('attendance_date')
            ->orderBy('punch_in')
            ->get();

        $fileName = 'work-history-'.str($workSite->site_name)->slug().'-'.$from.'-to-'.$to.'.xls';

        return response()->streamDownload(function () use ($records, $workSite, $from, $to) {
            echo '<html><head><meta charset="UTF-8"></head><body>';
            echo '<table border="1">';
            echo '<tr><th colspan="12" style="font-size:16px">'.e($workSite->site_name).' - Work History</th></tr>';
            echo '<tr><td colspan="12">Date: '.e($from).' to '.e($to).'</td></tr>';
            echo '<tr><th>Date</th><th>Work Site</th><th>Worker Code</th><th>Worker</th><th>Trade</th><th>Zone</th><th>Supervisor</th><th>Punch In</th><th>Punch Out</th><th>Hours</th><th>Work Description</th><th>Status</th></tr>';

            foreach ($records as $record) {
                $hours = $record->working_minutes ? number_format($record->working_minutes / 60, 2) : '0.00';
                echo '<tr>';
                echo '<td>'.e(optional($record->attendance_date)->format('d-m-Y')).'</td>';
                echo '<td>'.e($workSite->site_name).'</td>';
                echo '<td>'.e($record->worker?->worker_code ?? '').'</td>';
                echo '<td>'.e($record->worker?->name ?? 'Deleted worker').'</td>';
                echo '<td>'.e($record->worker?->trade ?? '').'</td>';
                echo '<td>'.e($record->siteZone?->zone_name ?? 'General').'</td>';
                echo '<td>'.e($record->supervisor?->name ?? $workSite->supervisor?->name ?? 'Not assigned').'</td>';
                echo '<td>'.e($record->punch_in ?? '').'</td>';
                echo '<td>'.e($record->punch_out ?? '').'</td>';
                echo '<td>'.$hours.'</td>';
                echo '<td>'.e($record->work_description ?? '').'</td>';
                echo '<td>'.e(ucfirst($record->status ?? '')).'</td>';
                echo '</tr>';
            }

            echo '</table></body></html>';
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }

    private function validatedDates(Request $request): array
    {
        $data = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        $from = Carbon::parse($data['from'] ?? now()->toDateString())->toDateString();
        $to = Carbon::parse($data['to'] ?? $from)->toDateString();

        return [$from, $to];
    }

    private function recordsQuery(WorkSite $workSite, string $from, string $to)
    {
        return WorkerAttendance::with(['worker', 'siteZone', 'supervisor', 'recordedBy'])
            ->where('work_site_id', $workSite->id)
            ->whereBetween('attendance_date', [$from, $to]);
    }
}
