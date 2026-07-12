<?php

namespace App\Enums;

enum GalleryCategory: string
{
    case AgencyExterior = 'agency_exterior';
    case Reception = 'reception';
    case InspectionLane = 'inspection_lane';
    case Staff = 'staff';
    case Equipment = 'equipment';
    case CustomerArea = 'customer_area';
}
