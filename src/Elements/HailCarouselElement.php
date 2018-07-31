<?php

namespace Firebrand\HailElemental\Elements;

use DNADesign\Elemental\Models\BaseElement;
use Firebrand\Hail\Pages\HailPage;
use Sheadawson\DependentDropdown\Forms\DependentDropdownField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\Requirements;

/**
 * Hail Carousel Elemental element
 *
 * @package silverstripe-hail-elemental
 * @author Marc Espiard, Firebrand
 * @version 1.0
 *
 * @property string $FilterTags
 * @property int $Limit
 * @property string $ShowDots
 * @property int $LargeToShow
 * @property int $LargeToScroll
 * @property int $MediumBreakpoint
 * @property int $MediumToShow
 * @property int $MediumToScroll
 * @property int $SmallBreakpoint
 * @property int $SmallToShow
 * @property int $SmallToScroll
 */
class HailCarouselElement extends BaseElement
{
    private static $table_name = 'HailCarouselElement';
    private static $controller_template = 'HailCarouselElementHolder';
    private static $db = [
        'FilterTags' => 'Text',
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
    private static $icon = 'hail-icon';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        //Multi tabs display
        $fields->addFieldToTab('Root.Main', TabSet::create('SubTabs', 'SubTabs', [Tab::create('Main'), Tab::create('Style')]));

        //Create new fields
        $limit = NumericField::create('Limit', 'Limit');
        $showdots = DropdownField::create('ShowDots', 'Show dots under the carousel', ['Yes' => 'Yes', 'No' => 'No']);
        $page = DropdownField::create('HailPageID', 'Hail Page', HailPage::get());
        $tag_source = function ($val) {
            $hailpage = DataObject::get_by_id(HailPage::class, $val);
            if ($hailpage) {
                return $hailpage->getAllowedPublicTags();
            }
            return [];
        };
        $filter_tags = DependentDropdownField::create('FilterTags', 'Public Tag displayed in the carousel', $tag_source)
            ->setDepends($page);

        $large_to_show = NumericField::create('LargeToShow', 'Large screens: Slides to show');
        $large_to_scroll = NumericField::create('LargeToScroll', 'Large screens: Slides to scroll');
        $medium_breakpoint = NumericField::create('MediumBreakpoint',
            'Medium screens: Breakpoint')->setDescription('The carousel will use the "Medium screens" settings when its width is under this value . In pixels . ');
        $medium_to_show = NumericField::create('MediumToShow', 'Medium screens: Slides to show');
        $medium_to_scroll = NumericField::create('MediumToScroll', 'Medium screens: Slides to scroll');
        $small_breakpoint = NumericField::create('SmallBreakpoint',
            'Small screens: Breakpoint')->setDescription('The carousel will use the "Small screens" settings when its width is under this value . In pixels . ');
        $small_to_show = NumericField::create('SmallToShow', 'Small screens: Slides to show');
        $small_to_scroll = NumericField::create('SmallToScroll', 'Small screens: Slides to scroll');

        //Add to tabs
        $fields->addFieldsToTab('Root.Main.SubTabs.Main', [
            $page,
            $filter_tags,
            $limit,
            $showdots,
        ]);
        $fields->addFieldsToTab('Root.Main.SubTabs.Style', [
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
        Requirements::css('firebrandhq/silverstripe-hail-elemental: client/dist/styles/hail-carousel.bundle.css');

        //Require jquery and bootstrap from Hail module to avoid double inclusion and to be able to globally disable this requirements for all hail modules
        Requirements::css('firebrandhq/silverstripe-hail: thirdparty/bootstrap/styles/bootstrap.min.css');
        Requirements::javascript('firebrandhq/silverstripe-hail: thirdparty/jquery/js/jquery.min.js');
        Requirements::javascript('firebrandhq/silverstripe-hail: thirdparty/bootstrap/js/bootstrap.bundle.min.js');

        Requirements::javascript('firebrandhq/silverstripe-hail-elemental: client/dist/js/hail-carousel.bundle.js');

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

    /**
     * Get the carousel items filtering them according to the element configuration
     *
     * @return PaginatedList
     */
    public function getCarouselItems()
    {
        $filter_tags = empty($this->FilterTags) || $this->FilterTags === "*" ? null : $this->FilterTags;

        return $this->HailPage()->getFullHailList($this->Limit, $filter_tags);
    }
}