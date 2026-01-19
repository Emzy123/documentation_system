<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\DocumentAudit;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Fetch recent audits and logs
        $audits = DocumentAudit::with(['document', 'user'])->latest()->paginate(15, ['*'], 'audits_page');
        $logs = ActivityLog::with('user')->latest()->paginate(15, ['*'], 'logs_page');

        return view('admin.reports.index', compact('audits', 'logs'));
    }
}
