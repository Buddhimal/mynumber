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
