<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Process;


class Hello
{
    #[Route('/')]
    public function hello()
    {
        // Validate the request, e.g., check if the user is authorized to generate the PDF.

        // Get the content of the .tex file (you may want to sanitize this input).
        $texContent = file_get_contents('./main.tex'); // Replace with your actual file path.

        // Create a temporary directory to store LaTeX files.
        $tempDir = sys_get_temp_dir().'/pdf_generation';
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        // Write the .tex content to a temporary .tex file.
        $texFilePath = $tempDir.'/output.tex';
        file_put_contents($texFilePath, $texContent);

        // Compile the .tex file into a PDF using LaTeX.
        $process = new Process(['pdflatex', '-output-directory', $tempDir, $texFilePath]);
        $process->run();

        if (!$process->isSuccessful()) {
            return new Response('PDF generation failed.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Send the generated PDF as a response.
        $pdfFilePath = $tempDir.'/output.pdf';
        $response = new Response($process->getOutput());
//        $response = new Response(file_get_contents($pdfFilePath));
//        $response->headers->set('Content-Type', 'application/pdf');
//        $response->headers->set('Content-Disposition', 'inline; filename="output.pdf"');

        return $response;

    }

}
