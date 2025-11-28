<?php

namespace App\Modules\Publication\Controllers\Site;

use App\Core\Helpers\FilePathHelper;
use App\Http\Controllers\Controller;
use App\Modules\Publication\Enums\HighlightTypeEnum;
use App\Modules\Publication\Models\ConatctMessage;
use App\Modules\Publication\Models\FavouriteBook;
use App\Modules\Publication\Requests\StoreContactMessageRequest;
use App\Modules\Publication\Services\Interfaces\AboutUsServiceInterface;
use App\Modules\Publication\Services\Interfaces\AuthorsServiceInterface;
use App\Modules\Publication\Services\Interfaces\BlogCategoryServiceInterface;
use App\Modules\Publication\Services\Interfaces\BlogServiceInterface;
use App\Modules\Publication\Services\Interfaces\BookCategoriesServiceInterface;
use App\Modules\Publication\Services\Interfaces\BookServiceInterface;
use App\Modules\Publication\Services\Interfaces\GalleryCategoryServiceInterface;
use App\Modules\Publication\Services\Interfaces\GalleryServiceInterface;
use App\Modules\Publication\Services\Interfaces\PageServiceInterface;
use App\Modules\Publication\Services\Interfaces\SliderServiceInterface;
use App\Modules\Publication\Services\Interfaces\VmgServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected string $viewPrefix = 'publication::site.';
    protected $PageService,
        $AboutUsService,
        $BookCategoriesService,
        $SliderService,
        $BookService,
        $bookCategoryService,
        $authorService,
        $vmgService,
        $blogService,
        $blogCategoryService,
        $GalleryCategoryService,
        $GalleryService;
    public function __construct(
        PageServiceInterface $PageService,
        AboutUsServiceInterface $AboutUsService,
        SliderServiceInterface $SliderService,
        BookServiceInterface $BookService,
        BookCategoriesServiceInterface $bookCategoryService,
        AuthorsServiceInterface $authorService,
        VmgServiceInterface $vmgService,
        BlogServiceInterface $blogService,
        BlogCategoryServiceInterface $blogCategoryService,
        GalleryCategoryServiceInterface $GalleryCategoryService,
        GalleryServiceInterface $GalleryService,
    ) {
        $this->PageService = $PageService;
        $this->AboutUsService = $AboutUsService;
        $this->SliderService = $SliderService;
        $this->BookService = $BookService;
        $this->bookCategoryService = $bookCategoryService;
        $this->authorService = $authorService;
        $this->vmgService = $vmgService;
        $this->blogService = $blogService;
        $this->blogCategoryService = $blogCategoryService;
        $this->GalleryCategoryService = $GalleryCategoryService;
        $this->GalleryService = $GalleryService;
    }

    public function index()
    {
        $data['about'] = $this->AboutUsService->aboutUsFormHome();
        $data['slider'] = $this->SliderService->getActiveSliders();
        $bestSelling = HighlightTypeEnum::BestSelling->value;
        $data['bestSellingBooks'] = $this->BookService->getPublishBooksByHighLightType($bestSelling)->take(5);
        $bestSelling = HighlightTypeEnum::FlashSale->value;
        $data['flashSaleBooks'] = $this->BookService->getPublishBooksByHighLightType($bestSelling)->take(4);
        $data['activeBookCategories'] = $this->bookCategoryService->getActiverCategoryNotInParent()->take(7);

        $data['activeAuthors'] = $this->authorService->getAuthors()->take(6);
        $data['vmgs'] = $this->vmgService->getActiveVmg();
        $data['blogs'] = $this->blogService->getActiveBlogs()->take(6);

        return view($this->viewPrefix . 'main.index', ['data' => $data]);
    }

    // single page for page
    public function singlePage($language, $slug)
    {
        $data['page'] = $this->PageService->getSinglePageBySlug($slug);
        $data['header_title'] = $data['page']->title ?? '';

        return view($this->viewPrefix . 'page.page.single', ['data' => $data]);
    }


    public function searchCategories($language, Request $request)
    {
        $response = $this->bookCategoryService->searchCategories($request->all());

        return view($this->viewPrefix . 'page.category.list', [
            'data' => $response['data']
        ]);
    }

    public function giveMeAllAuthors()
    {
        $data['activeAuthors'] = $this->authorService->getAuthors();

        return view($this->viewPrefix . 'page.authors.list', ['data' => $data]);
    }

    public function giveMeAllBlogs()
    {
        $data['blogs'] = $this->blogService->getActiveBlogs();
        $data['activeBlogCategories'] = $this->blogCategoryService->getActiveBlogCategories();
        return view($this->viewPrefix . 'page.blog.list', ['data' => $data]);
    }

    public function singleBlog($language, $slug)
    {
        $data['blog'] = $this->blogService->getBlogBySlug($slug);
        $data['activeBlogCategories'] = $this->blogCategoryService->getActiveBlogCategories();
        return view($this->viewPrefix . 'page.blog.detail', ['data' => $data]);
    }

    public function blogByCategorySlug($language, $slug)
    {
        dd($slug);
        $data['blogs'] = $this->blogService->getBlogsByCategorySlug($slug);
        $data['activeBlogCategories'] = $this->blogCategoryService->getActiveBlogCategories();
        return view($this->viewPrefix . 'page.blog.list', ['data' => $data]);   
    }

    public function searchBlogs($language, Request $request)
    {
        $data['blogs'] = $this->blogService->searchBlogs($request->all());
        $data['activeBlogCategories'] = $this->blogCategoryService->getActiveBlogCategories();

        return view($this->viewPrefix . 'page.blog.list', ['data' => $data]);
    }

    public function aboutUs()
    {
        $data['about'] = $this->AboutUsService->getActiveAboutUs();
        $data['vmgs'] = $this->vmgService->getActiveVmg();
        return view($this->viewPrefix . 'page.aboutUs.index', ['data' => $data]);
    }

    public function contactUs()
    {
        $data['header_title'] = 'Contact Us';
        return view($this->viewPrefix . 'page.contact.contact', ['data' => $data]);
    }

    public function storeContactMessages(StoreContactMessageRequest $request)
    {
        ConatctMessage::create($request->validated());

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    public function giveMeGallery()
    {
        $data['gallaries'] = $this->GalleryService->getGalleryData();
        $data['galleryCategories'] = $this->GalleryCategoryService->getActiveGalleryCategories();

        return view($this->viewPrefix . 'page.gallery.gallery', ['data' => $data]);
    }

}
