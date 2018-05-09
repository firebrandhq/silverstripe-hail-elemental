<?php

namespace Firebrand\HailElemental\Elements;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\View\Requirements;

class HailCarouselElement extends BaseElement
{
    private static $table_name = 'HailCarouselElement';

    private static $singular_name = 'hail carousel';

    private static $plural_name = 'hail carousels';

    private static $description = 'Add a Hail Carousel';

    private static $has_one = [
        "HailPage" => "Firebrand\Hail\Pages\HailPage",
    ];

    public function __construct(array $record = null, $isSingleton = false, array $queryParams = [])
    {
        parent::__construct($record, $isSingleton, $queryParams);
    }

    public function forTemplate($holder = true)
    {
        Requirements::css('resources/vendor/firebrand/silverstripe-hail-elemental/client/dist/styles/hail-carousel.bundle.css');
        Requirements::javascript('resources/vendor/firebrand/silverstripe-hail-elemental/client/dist/js/hail-carousel.bundle.js');

        return parent::forTemplate($holder);
    }

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