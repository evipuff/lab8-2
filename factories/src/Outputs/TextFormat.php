<?php

namespace App\Outputs;

use App\Outputs\ProfileFormatter;

class TextFormat implements ProfileFormatter
{
    private $response;

    public function setData($profile)
    {
        $output = "Full Name: " . $profile->getFullName() . PHP_EOL;
        $output .= "Date of Birth: " . $profile->getBirthInformation()['date_of_birth'] . PHP_EOL;
        $output .= "Birth Event: " . $profile->getBirthInformation()['birth_event'] . PHP_EOL;
        $output .= "Address: " . implode(", ", [
            $profile->getContactDetails()['address']['street'],
            $profile->getContactDetails()['address']['city'],
            $profile->getContactDetails()['address']['state'],
            $profile->getContactDetails()['address']['zip_code'],
            $profile->getContactDetails()['address']['country']
        ]) . PHP_EOL;

        //education
        $output .= "Education: " . $profile->getEducation()['degree'] . " at " . $profile->getEducation()['university'] . " (Graduated: " . $profile->getEducation()['graduation_date'] . ")" . PHP_EOL;
        
        //achievements
        $output .= "Achievements: " . implode("; ", $profile->getEducation()['achievements']) . PHP_EOL;

        //experience
        $output .= "Experience:" . PHP_EOL;
        foreach ($profile->getExperience() as $job) {
            $output .= "- " . $job['job_title'] . " at " . $job['organization'] . " (" . $job['start_date'] . " to " . ($job['end_date'] ?? 'Present') . ")" . PHP_EOL;
            $output .= "  Description: " . $job['description'] . PHP_EOL;
        }

        //philanthropy
        $output .= "Philanthropy:" . PHP_EOL;
        foreach ($profile->getPhilanthropy() as $philanthropy) {
            $output .= "- " . $philanthropy['role'] . " (Since: " . $philanthropy['start_date'] . ") - " . $philanthropy['description'] . PHP_EOL;
        }

        //values
        $output .= "Values: " . implode(", ", $profile->getValues()) . PHP_EOL;

        //languages
        $output .= "Languages:" . PHP_EOL;
        foreach ($profile->getLanguages() as $language) {
            $output .= "- " . $language['language'] . " - " . $language['proficiency'] . PHP_EOL;
        }

        $this->response = $output;
    }

    public function render()
    {
        header('Content-Type: text/plain');
        return $this->response;
    }
}
