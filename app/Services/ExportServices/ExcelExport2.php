<?php

namespace App\Services\ExportServices;

use App\Interfaces\Exportable;
use App\Models\Invoice;
use App\Services\CalendarServices\CalendarService;
use App\Traits\Exporter;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ExcelExport2 implements Exportable
{
    public static function export($dataTemplate, array $filters)
    {

        $writer = (new (config('exporter.services')['excel2']['dataTemplates'][$dataTemplate])($filters))->handle();

        return response()->streamDownload(function () use ($writer) {
            $writer->close();
        },
            $writer->getPath());
    }
}
