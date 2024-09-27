<?php

namespace App\Outputs;

use App\Outputs\ProfileFormatter;
use Fpdf\Fpdf;

class PDFFormat implements ProfileFormatter
{
    private $pdf;

    public function setData($profile)
    {
        ob_end_clean();

        $this->pdf = new Fpdf();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Cell(0, 10, 'Profile of ' . $profile->getFullName(), 0, 1, 'C');

        //personal information
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->Cell(0, 10, 'Date of Birth: ' . $profile->getBirthInformation()['date_of_birth'], 0, 1);
        $this->pdf->Cell(0, 10, 'Birth Event: ' . $profile->getBirthInformation()['birth_event'], 0, 1);
        
        //address
        $address = $profile->getContactDetails()['address'];
        $this->pdf->Cell(0, 10, 'Address: ' . implode(", ", [
            $address['street'],
            $address['city'],
            $address['state'],
            $address['zip_code'],
            $address['country']
        ]), 0, 1);

        //education
        $this->pdf->Cell(0, 10, 'Education: ' . $profile->getEducation()['degree'] . ' at ' . $profile->getEducation()['university'] . ' (Graduated: ' . $profile->getEducation()['graduation_date'] . ')', 0, 1);
        
        //achievements
        $this->pdf->Cell(0, 10, 'Achievements:', 0, 1);
        foreach ($profile->getEducation()['achievements'] as $achievement) {
            $this->pdf->Cell(0, 10, '- ' . $achievement, 0, 1);
        }

        //experience
        $this->pdf->Cell(0, 10, 'Experience:', 0, 1);
        foreach ($profile->getExperience() as $job) {
            $this->pdf->Cell(0, 10, '- ' . $job['job_title'] . ' at ' . $job['organization'] . ' (' . $job['start_date'] . ' to ' . ($job['end_date'] ?? 'Present') . ')', 0, 1);
            $this->pdf->Cell(0, 10, '  Description: ' . $job['description'], 0, 1);
        }

        //philanthrophic gesture
        $this->pdf->Cell(0, 10, 'Philanthropy:', 0, 1);
        foreach ($profile->getPhilanthropy() as $philanthropy) {
            $this->pdf->Cell(0, 10, '- ' . $philanthropy['role'] . ' (Since: ' . $philanthropy['start_date'] . ') - ' . $philanthropy['description'], 0, 1);
        }

        //values
        $this->pdf->Cell(0, 10, 'Values:', 0, 1);
        $this->pdf->MultiCell(0, 10, implode(", ", $profile->getValues()), 0, 1);

        //languages
        $this->pdf->Cell(0, 10, 'Languages:', 0, 1);
        foreach ($profile->getLanguages() as $language) {
            $this->pdf->Cell(0, 10, '- ' . $language['language'] . ' - ' . $language['proficiency'], 0, 1);
        }

        //final output
        $this->pdf->Output('I', 'Profile_' . str_replace(' ', '_', $profile->getFullName()) . '.pdf'); // Use 'I' to display inline
    }

    public function render()
    {
        return $this->pdf;
    }
}
