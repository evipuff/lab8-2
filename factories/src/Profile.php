<?php

namespace App;

class Profile
{
    private $name;
    private $birthInformation;
    private $contactInformation;
    private $education;
    private $experience = [];
    private $languages = [];
    private $philanthropy = [];
    private $values = [];

    public function __construct($data = null)
    {
        // Map the data to the class properties
        if (isset($data['personal_information'])) {
            $info = $data['personal_information'];

            $this->name = $info['name'];
            $this->birthInformation = $info['birth_information']; // Initialize birth information
            $this->contactInformation = $info['contact_information'];
            $this->education = $data['education'];
            $this->experience = $data['experience'];
            $this->languages = $data['languages'];
            $this->philanthropy = $data['philanthropy']; // Initialize philanthropy
            $this->values = $data['values']; // Initialize values
        }
    }

    public function getFullName()
    {
        return $this->name['first_name'] . ' ' . $this->name['middle_initial'] . '. ' . $this->name['last_name'];
    }

    public function getBirthInformation()
    {
        return $this->birthInformation; // Return the birth information
    }

    public function getContactDetails()
    {
        return $this->contactInformation;
    }

    public function getEducation()
    {
        return $this->education;
    }

    public function getExperience()
    {
        return $this->experience;
    }

    public function getLanguages()
    {
        return $this->languages;
    }

    public function getPhilanthropy()
    {
        return $this->philanthropy; // Return the philanthropy
    }

    public function getValues()
    {
        return $this->values; // Return the values
    }
}
