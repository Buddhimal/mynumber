<?php

class EntityType
{
	const Patient = 0;
	const Consultant = 1;
	const SalesRep = 2;
}


class APIResponseCode{
	const SUCCESS = 2000;
	const SUCCESS_WITH_ERRORS = 2001;
	const INTERNAL_SERVER_ERROR = 5000;
	const BAD_REQUEST = 4000;
	const UNAUTHORIZED = 4010;
	const METHOD_NOT_ALLOWED = 4050;
}

class AppointmentStatus{
	const PENDING =0;
	const CANCELED =1;
	const SKIPPED =2;
	const FINISH =3;
	const CONSULTED =1;
	const NOT_CONSULTED =2;

}


class StatusCode{
	const TRUE = 1;
	const FALSE = 0;
}

class SessionStatus{
	const START = 1;
	const CANCELED = 2;
	const TIME_REVERSED = 3;
	const FINISHED = 4;
	const TERMINATED = 5;
}
