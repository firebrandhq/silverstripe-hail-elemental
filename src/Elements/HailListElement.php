<?php

namespace Firebrand\HailElemental\Elements;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\RequiredFields;

class HailCarouselElement extends BaseElement
{
    private static $table_name = 'HailCarouselElement';

    private static $singular_name = 'hail carousel';

    private static $plural_name = 'hail carousels';

    private static $description = 'Add a Hail Carousel';

    private static $has_one = [
        "HailPage" => "Firebrand\Hail\Pages\HailPage",
    ];

    public function getCMSValidator()
    {
        return new RequiredFields([
            'HailPageID',
        ]);
    }


    public function getType()
    {
        return 'Hail Carousel';
    }
}