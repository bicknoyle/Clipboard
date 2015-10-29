<?php

namespace App\Repositories;

use App\Survey;

class SurveyRepository extends AbstractRepository
{
	public function __construct(Survey $survey)
	{
		$this->model = $survey;
	}
}