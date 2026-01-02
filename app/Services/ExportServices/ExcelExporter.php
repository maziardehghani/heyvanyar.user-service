<?php

namespace App\Services\ExportServices;

use App\Interfaces\Exportable;


class ExcelExporter implements Exportable
{
    public static function export($dataTemplate, array $filters)
    {
        $exportModule = config('exporter.services')['excel']['dataTemplates'][$dataTemplate];

        return (new $exportModule($filters))->download("$dataTemplate.xlsx");
    }
}












































//        if (!$list instanceof FromQuery &
//            !$list instanceof WithMapping &
//            !$list instanceof WithHeadings) {
//
//            throw new InvalidParameterException();
//        }
