<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class GenerateGuidebook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guidebook:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate PDF guidebook for the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating guidebook PDF...');

        try {
            // Create guidebook directory if it doesn't exist
            $guidebookPath = public_path('guidebook');
            if (!File::exists($guidebookPath)) {
                File::makeDirectory($guidebookPath, 0755, true);
                $this->info('Created guidebook directory: ' . $guidebookPath);
            }

            // Generate PDF
            $pdf = Pdf::loadView('pdf.guidebook');
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'dpi' => 150,
                'defaultFont' => 'Times New Roman',
                'margin-top' => 20,
                'margin-right' => 20,
                'margin-bottom' => 20,
                'margin-left' => 20,
            ]);

            // Save PDF to public/guidebook/
            $filename = 'panduan-sistem-perizinan.pdf';
            $filepath = $guidebookPath . '/' . $filename;
            
            $pdf->save($filepath);

            $this->info('Guidebook PDF generated successfully!');
            $this->info('File saved to: ' . $filepath);
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error generating guidebook: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            return Command::FAILURE;
        }
    }
}

