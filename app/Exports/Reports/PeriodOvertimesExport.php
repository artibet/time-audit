<?php

namespace App\Exports\Reports;

use Artibet\Laralib\Abstracts\ExportBase;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeriodOvertimesExport extends ExportBase
{
  private iterable $records;

  // ---------------------------------------------------------------------------------------
  // Constructor - set records
  // ---------------------------------------------------------------------------------------
  public function __construct(iterable $records)
  {
    $this->records = $records;
  }

  // ---------------------------------------------------------------------------------------
  // Override: templatePath()
  // ---------------------------------------------------------------------------------------
  protected function templatePath(): string
  {
    return storage_path('app/private/templates/period_overtimes.xlsx');
  }

  // ---------------------------------------------------------------------------------------
  // Override: filename
  // ---------------------------------------------------------------------------------------
  protected function filename(): string
  {
    return "Υπερωρίες_περιόδου.xlsx";
  }

  // ---------------------------------------------------------------------------------------
  // Override: build($sheet)
  // ---------------------------------------------------------------------------------------
  protected function build(Worksheet $sheet): void
  {
    $row = 2;
    foreach ($this->records as $record) {
      $sheet->setCellValue("A{$row}", $row - 1);
      $sheet->setCellValue("B{$row}", $record->lastname);
      $sheet->setCellValue("C{$row}", $record->firstname);
      // D - Κλάδος
      // E - Μ.Κ.
      $sheet->setCellValue("F{$row}", $record->total_capped_hours);
      $row += 1;
    }
  }
}
