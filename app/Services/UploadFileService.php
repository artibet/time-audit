<?php

namespace App\Services;

use Carbon\Carbon;
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
      $punchedAt = $rowData['date']->copy()->setTimeFrom($rowData['time']);
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
      'lastname'   => ['type' => 'string', 'aliases' => ['Επώνυμο', 'ΕΠΩΝΥΜΟ', 'lastname']],
      'firstname'  => ['type' => 'string', 'aliases' => ['Όνομα', 'ΟΝΟΜΑ', 'firstname']],
      'am'         => ['type' => 'string', 'aliases' => ['ΑΜ', 'αμ', 'AM', 'am']],
      'clock_code' => ['type' => 'string', 'aliases' => ['Κωδικός ρολογιού', 'ΚΩΔΙΚΟΣ ΡΟΛΟΓΙΟΥ', 'clock_code']],
      'card_no'    => ['type' => 'string', 'aliases' => ['Κάρτα', 'ΚΑΡΤΑ', 'card_no']],
      'date'       => ['type' => 'date', 'aliases' => ['Ημερομηνία', 'ΗΜΕΡΟΜΗΝΙΑ', 'date']],
      'time'       => ['type' => 'time', 'aliases' => ['Ώρα', 'ΩΡΑ', 'time']],
      'direction'  => ['type' => 'string', 'aliases' => ['Κατάσταση', 'κατάσταση', 'direction']],
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
      if (is_null($value) || trim($value) === '') {
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
            // Αντικαθιστούμε το raw string/number με έτοιμο Carbon instance
            $rowData[$key] = is_numeric($value)
              ? Carbon::instance(ExcelDate::excelToDateTimeObject($value))->setTimezone('Europe/Athens')->startOfDay()
              : Carbon::parse($value)->setTimezone('Europe/Athens')->startOfDay();
          } catch (\Exception $e) {
            throw new \Exception("Σφάλμα στη γραμμή {$rowNumber}: Η τιμή '{$value}' στη στήλη '{$columnNameForUser}' δεν είναι έγκυρη ημερομηνία.");
          }
          break;

        case 'time':
          try {
            // Αντικαθιστούμε το raw string/number με έτοιμο Carbon instance
            $rowData[$key] = is_numeric($value)
              ? Carbon::instance(ExcelDate::excelToDateTimeObject($value))->setTimezone('Europe/Athens')
              : Carbon::parse($value)->setTimezone('Europe/Athens');
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
          } else {
            // Για τα υπόλοιπα strings (firstname, lastname), απλά κάνουμε trim
            $rowData[$key] = $trimmedValue;
          }
          break;
      }
    }
  }
}
