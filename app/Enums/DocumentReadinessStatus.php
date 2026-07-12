<?php

namespace App\Enums;

enum DocumentReadinessStatus: string
{
    case NotReviewed = 'not_reviewed';
    case Complete = 'complete';
    case MissingInfo = 'missing_info';
    case ContactAgency = 'contact_agency';
    case ReadyForVisit = 'ready_for_visit';
}
