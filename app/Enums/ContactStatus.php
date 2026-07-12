<?php

namespace App\Enums;

enum ContactStatus: string
{
    case New = 'new';
    case InReview = 'in_review';
    case Responded = 'responded';
    case Closed = 'closed';
    case Spam = 'spam';
}
