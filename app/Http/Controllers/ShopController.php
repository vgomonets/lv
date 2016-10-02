<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\SearchRequest;
use App\Repositories\ShopRepository;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * The BlogFrontController instance.
     *
     * @var \App\Repositories\BlogRepository
     */
    protected $shopRepository;

    /**
     * The pagination number.
     *
     * @var int
     */
    protected $nbrPages;

    /**
     * Create a new BlogController instance.
     *
     * @param  \App\Repositories\BlogRepository $blogRepository
     * @return void
    */
    public function __construct(ShopRepository $blogRepository)
    {
        $this->shopRepository = $blogRepository;
        $this->nbrPages = config('app.nbrPages.front.posts');
    }

    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->shopRepository->getActiveWithUserOrderByDate($this->nbrPages);

        return view('front.shop.index', compact('posts'));
    }


    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function back(Request $request)
    {
        $statut = session('statut');
        $posts = $this->shopRepository->getItemsWithOrder(
            config('app.nbrPages.back.posts'),
            $request->name
        );

        $links = $posts->appends([
            'name' => $request->name,
            'sens' => $request->sens
        ]);

        if ($request->ajax()) {
            return [
                'view' => view('back.blog.table', compact('statut', 'posts'))->render(),
                'links' => e($links->setPath('order')->links()),
            ];
        }

        $links->links();

        $order = new \stdClass;
        $order->name = $request->name;
        $order->sens = 'sort-' . $request->sens;

        return view('back.shop.index', compact('posts', 'links', 'order'));
    }

    /**
     * Display the specified post.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $user = $request->user();

        return view('front.shop.show', array_merge($this->shopRepository->getPostBySlug($slug), compact('user')));
    }

    public function create()
    {
        return view('back.shop.create');
    }

    public function store(PostRequest $request)
    {
        $this->shopRepository->store($request->all(), $request->user()->id);

        return redirect('blog')->with('ok', trans('back/blog.stored'));
    }
    /**
     * Get tagged posts
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function tag(Request $request)
    {
        $tag = $request->input('tag');
        $posts = $this->shopRepository->getActiveWithUserOrderByDateForTag($this->nbrPages, $tag);
        $links = $posts->appends(compact('tag'))->links();
        $info = trans('front/shop.info-tag') . '<strong>' . $this->shopRepository->getTagById($tag) . '</strong>';
        
        return view('front.shop.index', compact('posts', 'links', 'info'));
    }

    /**
     * Find search in blog
     *
     * @param  \App\Http\Requests\SearchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchRequest $request)
    {
        $search = $request->input('search');
        $posts = $this->shopRepository->search($this->nbrPages, $search);
        $links = $posts->appends(compact('search'))->links();
        $info = trans('front/blog.info-search') . '<strong>' . $search . '</strong>';
        
        return view('front.shop.index', compact('posts', 'links', 'info'));
    }
}
