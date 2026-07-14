<?php

namespace App\Services;

use Carbon\Carbon;
use DateTimeZone;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class UploadFileService
{
  /**
   * Process the temporary request file path and extract verified data.
   *
   * @param string $filePath
   * @return array
   * @throws \Exception
   */
  public function process(string $filePath): array
  {
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = [];   // Rows to be returned

    $columns = $this->validateColumns($worksheet);
    $lastRow = $worksheet->getHighestRow();

    // Αρχικοποίηση μεταβλητών για τα όρια των ημερομηνιών
    $minDate = null;
    $maxDate = null;

    // Κρατάμε τα am των υπαλλήλων για να υπολογίσουμε το πλήθος των μοναδικών
    $employeeAms = [];

    // Itterate rows
    for ($row = 2; $row <= $lastRow; $row++) {
      $rowData = [];
      foreach ($columns as $key => $letter) {
        $rowData[$key] = $worksheet->getCell("{$letter}{$row}")->getValue();
      }
      $this->validateAndSanitizeRow($rowData, $row);

      // Συνδυάζουμε την ημερομηνία και την ώρα σε ένα τελικό punched_at timestamp
      $punchedAt = $rowData['date']->copy()->setTimeFrom($rowData['time'])->utc();
      $rowData['punched_at'] = $punchedAt;

      // Update min/max date
      if (is_null($minDate) || $punchedAt->lt($minDate)) {
        $minDate = $punchedAt;
      }
      if (is_null($maxDate) || $punchedAt->gt($maxDate)) {
        $maxDate = $punchedAt;
      }

      // Κρατάμε το am της γραμμής
      $employeeAms[] = $rowData['am'];

      // Add to rows to be returned
      $rows[] = $rowData;
    }

    // Return parsed data
    return [
      'rows' => $rows,
      'starts_at' => $minDate,
      'ends_at' => $maxDate,
      'employees_count' => count(array_unique($employeeAms))
    ];
  }

  /**
   * Required header columns - must present in the xlsx (in any order)
   *
   * @return array
   */
  protected function getRequiredColumns(): array
  {
    return [
      'lastname'      => ['type' => 'string', 'aliases' => ['Επώνυμο', 'ΕΠΩΝΥΜΟ', 'lastname'], 'required' => true],
      'firstname'     => ['type' => 'string', 'aliases' => ['Όνομα', 'ΟΝΟΜΑ', 'firstname'], 'required' => true],
      'am'            => ['type' => 'string', 'aliases' => ['ΑΜ', 'αμ', 'AM', 'am'], 'required' => true],
      'clock_code'    => ['type' => 'string', 'aliases' => ['Κωδικός ρολογιού', 'ΚΩΔΙΚΟΣ ΡΟΛΟΓΙΟΥ', 'clock_code'], 'required' => true],
      'card_no'       => ['type' => 'string', 'aliases' => ['Κάρτα', 'ΚΑΡΤΑ', 'card_no'], 'required' => true],
      'date'          => ['type' => 'date', 'aliases' => ['Ημερομηνία', 'ΗΜΕΡΟΜΗΝΙΑ', 'date'], 'required' => true],
      'time'          => ['type' => 'time', 'aliases' => ['Ώρα', 'ΩΡΑ', 'time'], 'required' => true],
      'direction'     => ['type' => 'string', 'aliases' => ['Κατάσταση', 'κατάσταση', 'direction'], 'required' => true],
      'shift_string'  => ['type' => 'string', 'aliases' => ['Βάρδια', 'ΒΑΡΔΙΑ', 'shift_string'], 'required' => true],
    ];
  }

  /**
   * Validate the presence of mandatory column headers.
   *
   * @param Worksheet $worksheet
   * @return array Map of lowercased headers to column letters
   * @throws Exception
   */
  protected function validateColumns(Worksheet $worksheet): array
  {
    $columns = [];
    $requiredHeaders = $this->getRequiredColumns();

    // Read the first row exclusively 
    // and map header label to header letter (A, B, C, ..)
    foreach ($worksheet->getRowIterator(1, 1) as $rowIterator) {
      foreach ($rowIterator->getCellIterator() as $cell) {
        $columnLabel = trim($cell->getValue());
        if (empty($columnLabel)) {
          continue;
        }
        // See if the column label is into requiredHeaders
        foreach ($requiredHeaders as $key => $data) {
          if (in_array($columnLabel, $data['aliases'])) {
            $columns[$key] = $cell->getColumn();
          }
        }
      }
    }

    // Check what is missing
    $missing = [];
    foreach ($requiredHeaders as $key => $values) {
      if (!isset($columns[$key])) {
        $missing[] = $key;
      }
    }
    if (!empty($missing)) {
      throw new Exception('Μη έγκυρη μορφή αρχείου. Λείπουν οι εξής στήλες: ' . implode(', ', $missing));
    }

    // Detected column mapping
    return $columns;
  }

  /**
   * Ελέγχει αν η γραμμή έχει όλα τα απαραίτητα δεδομένα και αν είναι του σωστού τύπου.
   *
   * @param array &$rowData Τα δεδομένα  της γραμμής αποθηκευμένα με βάση το key (π.χ. ['date' => '...'])
   * @param int $rowNumber Ο αριθμός της γραμμής στο Excel για το μήνυμα λάθους
   * @throws \Exception
   */
  protected function validateAndSanitizeRow(array &$rowData, int $rowNumber): void
  {
    $requiredColumns = $this->getRequiredColumns();

    foreach ($requiredColumns as $key => $config) {
      $value = $rowData[$key] ?? null;
      $columnNameForUser = $config['aliases'][1] ?? $key; // Το ελληνικό όνομα για το error

      // 1. Έλεγχος αν είναι κενό
      if ((is_null($value) || trim($value) === '') && $config['required']) {
        throw new \Exception("Σφάλμα στη γραμμή {$rowNumber}: Η στήλη '{$columnNameForUser}' είναι κενή.");
      }

      // 2. Έλεγχος Τύπου Δεδομένων & μετατροπή
      switch ($config['type']) {
        case 'numeric':
          if (!is_numeric($value)) {
            throw new \Exception("Σφάλμα στη γραμμή {$rowNumber}: Η στήλη '{$columnNameForUser}' πρέπει να είναι αριθμός (βρέθηκε: '{$value}').");
          }
          break;

        case 'date':
          try {
            if (is_numeric($value)) {
              // 1. Μετατροπή του Excel αριθμού σε native PHP DateTime (έρχεται ως UTC από το PhpSpreadsheet)
              $timezone = new DateTimeZone('Europe/Athens');
              $nativeDt = ExcelDate::excelToDateTimeObject($value, $timezone);

              // 2. Μετατροπή σε Carbon instance
              $carbonDate = Carbon::instance($nativeDt);
              $rowData[$key] = $carbonDate;
            } else {
              // Αν είναι string (π.χ. "2026-07-11" ή "11/07/2026"), το κάνουμε parse απευθείας στην ώρα Ελλάδος
              $rowData[$key] = Carbon::parse($value, 'Europe/Athens');
            }
          } catch (\Exception $e) {
            throw new \Exception("Σφάλμα στη γραμμή {$rowNumber}: Η τιμή '{$value}' στη στήλη '{$columnNameForUser}' δεν είναι έγκυρη ημερομηνία.");
          }
          break;

        case 'time':
          try {
            if (is_numeric($value)) {
              // 1. Το Excel επιστρέφει native PHP DateTime σε UTC (π.χ. 08:00 UTC)
              $timezone = new DateTimeZone('Europe/Athens');
              $nativeDt = ExcelDate::excelToDateTimeObject($value, $timezone);
              // 2. Το μετατρέπουμε σε Carbon, κρατώντας το UTC αρχικά
              $carbonTime = Carbon::instance($nativeDt);
              $rowData[$key] = $carbonTime;
            } else {
              // Αν είναι string (π.χ. "08:30"), το κάνουμε parse κατευθείαν στην ώρα Ελλάδος
              $rowData[$key] = Carbon::parse($value, 'Europe/Athens');
            }
          } catch (\Exception $e) {
            throw new \Exception("Σφάλμα στη γραμμή {$rowNumber}: Η τιμή '{$value}' στη στήλη '{$columnNameForUser}' δεν είναι έγκυρη ώρα.");
          }
          break;

        case 'string':
        default:
          $trimmedValue = trim($value);

          // Ειδική διαχείριση για τη στήλη της κατεύθυνσης (direction)
          if ($key === 'direction') {
            // Μετατροπή σε πεζά για να πιάσουμε όλες τις περιπτώσεις (π.χ. Είσοδος, ΕΙΣΟΔΟΣ)
            $lowerVal = mb_strtolower($trimmedValue, 'UTF-8');

            if (in_array($lowerVal, ['είσοδος', 'εισοδος', 'ε', 'in'])) {
              $rowData[$key] = 'in';
            } elseif (in_array($lowerVal, ['έξοδος', 'εξοδος', 'ξ', 'out'])) {
              $rowData[$key] = 'out';
            } else {
              // Αν βρεθεί κάτι άκυρο (π.χ. "Άγνωστο" ή λάθος χαρακτήρες), πετάμε Exception
              throw new \Exception("Σφάλμα στη γραμμή {$rowNumber}: Μη έγκυρη τιμή στην στήλη 'Κατάσταση' (βρέθηκε: '{$trimmedValue}').");
            }
          }

          // Ειδική διαχείριση για τη στήλη της βάρδιας (shift_string)
          else if ($key === 'shift_string') {
            if (preg_match('/(\d{2}:\d{2})\s*-\s*(\d{2}:\d{2})/', $trimmedValue, $matches)) {
              $rowData[$key] = $trimmedValue; // Keep the original string if needed
              $rowData['shift_start'] = Carbon::createFromFormat('H:i', $matches[1], 'Europe/Athens');
              $rowData['shift_end']   = Carbon::createFromFormat('H:i', $matches[2], 'Europe/Athens');
              $rowData[$key] = "{$matches[1]} - {$matches[2]}";
            } else {
              // Set default 
              $defaultShiftStart = '07:00';
              $defaultShiftEnd = '15:00';
              $rowData['shift_start'] = Carbon::createFromFormat('H:i', $defaultShiftStart, 'Europe/Athens');
              $rowData['shift_end'] = Carbon::createFromFormat('H:i', $defaultShiftEnd, 'Europe/Athens');

              // Format shift string
              $rowData[$key] = "{$defaultShiftStart} - {$defaultShiftEnd}";
            }
          }

          // Για τα υπόλοιπα strings (firstname, lastname, κλπ), απλά κάνουμε trim
          else {
            // Για τα υπόλοιπα strings (firstname, lastname), απλά κάνουμε trim
            $rowData[$key] = $trimmedValue;
          }
          break;
      }
    }
  }
}
