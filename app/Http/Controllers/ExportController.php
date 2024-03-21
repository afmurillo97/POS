<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use League\Csv\Writer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExportController extends Controller
{
    // Parameters necessary to generate any query
    protected $table_name;
    protected $columns;
    protected $elements;

    /**
     * Generate CSV Document.
     */
    public function csv(Request $request): StreamedResponse
    {
        $this->initializeExportData($request);

        $csv = Writer::createFromString('');

        // Add Headers
        $csv->insertOne($this->columns);

        foreach ($this->elements as $element) {
            $csv->insertOne($element->toArray());
        }

        return $this->downloadResponse($csv->toString(), $this->table_name . '.csv');
    }

    /**
     * Generate XLSX Document.
     */
    public function excel(Request $request): StreamedResponse
    {
        $this->initializeExportData($request);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add Headers 
        $sheet->fromArray($this->columns, NULL, 'A1');

        foreach ($this->elements as $key => $element) {
            $row = $key + 2;
            $sheet->fromArray($element->toArray(), NULL, 'A' . $row);
        }

        ob_start();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $content = ob_get_clean();

        $filename = $this->table_name . '.xlsx';
        return $this->downloadResponse($content, $filename, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /**
     * Generate PDF Document.
     */
    public function pdf(Request $request): StreamedResponse
    {
        $this->initializeExportData($request);

        // Crear un objeto Dompdf
        $dompdf = new Dompdf();

        // Opciones del documento PDF (puedes ajustarlas según sea necesario)
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf->setOptions($options);

        $html = '
            <table style="width: 100%;">
                <thead style="background-color: #ccc;">
                    <tr>
        ';

        foreach ($this->columns as $column) {
            $html .= '<th>' . $column . '</th>';
        }
        $html .= '
                    </tr>
                </thead>
        ';

        // Filas de datos alternadas
        $html .= '<tbody>';
        foreach ($this->elements as $key => $element) {
            $html .= '<tr ' . ($key % 2 == 0 ? 'style="background-color: #f2f2f2;"' : '') . '>';
            foreach ($element->toArray() as $data) {
                $texto = $this->insertSpaces($data);
                $html .= '<td>' . $texto . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';

        $html .= '</table>';

        // Cargar HTML en el objeto Dompdf
        $dompdf->loadHtml($html);

        // Renderizar el PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $pdfContent = $dompdf->output();

        // Llamar al método de descarga utilizando el contenido del PDF
        return $this->downloadResponse($pdfContent, $this->table_name . '.pdf', 'application/pdf');
    }

    /**
     * Initialize Required Data.
     */
    protected function initializeExportData(Request $request): void
    {
        $this->table_name = $request->input('table_name');

        if ($this->table_name === null) {
            abort(400, "The parameter 'table_name' is necessary.");
        }

        $this->columns = Schema::getColumnListing($this->table_name);
        if (empty($this->columns)) {
            abort(500, "No columns found for table '{$this->table_name}'.");
        }

        $this->elements = $this->getElements();
        if ($this->elements->isEmpty()) {
            abort(500, "No elements found for table '{$this->table_name}'.");
        }
    }

    /**
     * Get elements for export.
     */
    protected function getElements(): Collection
    {
        // No export columns
        $restrictedColumns = ['created_at', 'updated_at'];

        $modelName = ucfirst(Str::singular($this->table_name));

        // Check if the model exists
        if (!class_exists('App\\Models\\'.$modelName)) {
            abort(500, "Model '{$modelName}' not found.");
        }

        // Exclude restricted columns
        $query = call_user_func('App\\Models\\'.$modelName.'::select', array_diff($this->columns, $restrictedColumns));

        $this->columns = array_diff($this->columns, $restrictedColumns);

        // Execute query and return elements
        return $query->get();
    }

    /**
     * Download Finished File.
     */
    protected function downloadResponse($content, $filename, $contentType = 'text/csv'): StreamedResponse
    {
        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    
    /**
     * Prepare data for PDF case.
     */
    private function insertSpaces($data): String {
        // Divide la cadena en palabras
        $words = explode(' ', $data);
        
        // Recorre cada palabra
        foreach ($words as &$word) {
            // Verifica si la primera palabra es más larga que 10 caracteres
            if (strlen($word) > 10) {
                // Divide la palabra en subcadenas de 10 caracteres y las une con un espacio
                $word = implode(' ', str_split($word, 10));
            }
        }
        
        // Une las palabras nuevamente en una cadena
        $result = implode(' ', $words);
        
        return $result;
    }
}
