<?php

namespace Firebrand\HailElemental\Elements;

use DNADesign\Elemental\Models\BaseElement;
use Firebrand\Hail\Pages\HailPage;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\View\Requirements;

class HailCarouselElement extends BaseElement
{
    private static $table_name = 'HailCarouselElement';

    private static $db = [
        'Limit' => 'Int',
        'ShowDots' => 'Enum(array("Yes","No"))',
        'LargeToShow' => 'Int',
        'LargeToScroll' => 'Int',
        'MediumBreakpoint' => 'Int',
        'MediumToShow' => 'Int',
        'MediumToScroll' => 'Int',
        'SmallBreakpoint' => 'Int',
        'SmallToShow' => 'Int',
        'SmallToScroll' => 'Int',
    ];

    private static $defaults = [
        'Limit' => 9,
        'ShowDots' => 'No',
        'LargeToShow' => 3,
        'LargeToScroll' => 3,
        'MediumBreakpoint' => 1024,
        'MediumToShow' => 2,
        'MediumToScroll' => 2,
        'SmallBreakpoint' => 600,
        'SmallToShow' => 1,
        'SmallToScroll' => 1,
    ];

    private static $singular_name = 'hail carousel';

    private static $plural_name = 'hail carousels';

    private static $description = 'Add a Hail Carousel';

    private static $has_one = [
        "HailPage" => "Firebrand\Hail\Pages\HailPage",
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $page = DropdownField::create('HailPageID', 'Hail Page', HailPage::get());
        $fields->insertAfter('TitleAndDisplayed', $page);

        $large_to_show = NumericField::create('LargeToShow', 'Large screens: Slides to show');
        $large_to_scroll = NumericField::create('LargeToScroll', 'Large screens: Slides to scroll');
        $medium_breakpoint = NumericField::create('MediumBreakpoint',
            'Medium screens: Breakpoint')->setDescription('The carousel will use the "Medium screens" settings when its width is under this value. In pixels.');
        $medium_to_show = NumericField::create('MediumToShow', 'Medium screens: Slides to show');
        $medium_to_scroll = NumericField::create('MediumToScroll', 'Medium screens: Slides to scroll');
        $small_breakpoint = NumericField::create('SmallBreakpoint',
            'Small screens: Breakpoint')->setDescription('The carousel will use the "Small screens" settings when its width is under this value. In pixels.');
        $small_to_show = NumericField::create('SmallToShow', 'Small screens: Slides to show');
        $small_to_scroll = NumericField::create('SmallToScroll', 'Small screens: Slides to scroll');

        $fields->addFieldsToTab('Root.Main', [
            $large_to_show,
            $large_to_scroll,
            $medium_breakpoint,
            $medium_to_show,
            $medium_to_scroll,
            $small_breakpoint,
            $small_to_show,
            $small_to_scroll,
        ]);
        return $fields;
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

    public function getCarouselItems()
    {
        return $this->HailPage()->getFullHailList($this->Limit);
    }
}