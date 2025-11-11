<?php

namespace App\Modules\Publication\Controllers\Site;

use App\Core\Helpers\FilePathHelper;
use App\Http\Controllers\Controller;
use App\Modules\Publication\Enums\HighlightTypeEnum;
use App\Modules\Publication\Services\Interfaces\AboutUsServiceInterface;
use App\Modules\Publication\Services\Interfaces\BookCategoriesServiceInterface;
use App\Modules\Publication\Services\Interfaces\BookServiceInterface;
use App\Modules\Publication\Services\Interfaces\PageServiceInterface;
use App\Modules\Publication\Services\Interfaces\SliderServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected string $viewPrefix = 'publication::site.';
    protected $PageService, $AboutUsService,$BookCategoriesService,$SliderService,$BookService;
    public function __construct(
        PageServiceInterface $PageService,
        AboutUsServiceInterface $AboutUsService,
        BookCategoriesServiceInterface $BookCategoriesService,
        SliderServiceInterface $SliderService,
        BookServiceInterface $BookService
        )
    {
        $this->PageService = $PageService;
        $this->AboutUsService = $AboutUsService;
        $this->BookCategoriesService = $BookCategoriesService;
        $this->SliderService = $SliderService;
        $this->BookService = $BookService;
    }

    public function index()
    {
        $data['about'] = $this->AboutUsService->getActiveAboutUs();
        $data['BookCategories'] = $this->BookCategoriesService->getActiveBookCategories()->take(4);
        $data['slider'] = $this->SliderService->getActiveSliders();
        $bestSelling = HighlightTypeEnum::BestSelling->value;
        $data['bestSellingBooks'] = $this->BookService->getPublishBooksByHighLightType($bestSelling)->take(5);
        $bestSelling = HighlightTypeEnum::FlashSale->value;
        $data['flashSaleBooks'] = $this->BookService->getPublishBooksByHighLightType($bestSelling)->take(4);


        return view($this->viewPrefix . 'main.index', ['data' => $data]);
    }

    public function getBookDetailBySlug($language,$slug)
    {
        $data['header_title'] = $slug;

        $data['book'] = $this->BookService->getSingleBookBySlug($slug);
        // dd($data['book']);

        if (!$data['book']) {
            abort(404);
        }

        return view($this->viewPrefix . 'page.book.single', ['data' => $data]);
    }

      public function singlePage($language,$slug)
    {
        $data['page'] = $this->PageService->getSinglePageBySlug($slug);
        $data['header_title'] = $data['page']->title ?? '';

        if (!$data['page']) {
            abort(404);
        }

        return view($this->viewPrefix . 'page.page.single', ['data' => $data]);
    }


}
