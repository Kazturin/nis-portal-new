<?php

namespace App\View\Components;

use App\Enums\MenuTypeEnum;
use App\Models\Alumni\AlumniMenu;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Product\Product;
use App\Models\TextWidget;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class Layout extends Component
{
    public $menu;
    public $footerMenu;
    public $schools;
    public $call_center;
    public $trademark;
    public $products;
    public $alumni_menu;
    public $helpline;
    public $top_button;

    /**
     * Create a new component instance.
     */
    public function __construct(public ?string $metaTitle = null, public ?string $metaDescription = null, public ?string $metaImage = null)
    {
        $this->menu = Cache::remember('menu', now()->addDays(1), function() {
            return Menu::with(['page','children' => function($q){
                $q->with(['page','children' => function($c){
                    $c->with(['page','children' => function($l){
                       $l->with('page')->where('active',true)->orderBy('sort');
                     }])->where('active',true)->orderBy('sort');
                }])->where('active',true)->orderBy('sort');
            }, 'parent'])->where(["active"=>true,'parent_id'=>NULL, 'position' => Menu::POSITION_HEADER])->orderBy('sort')->get()->toArray();
        }); 
        $this->menu = $this->hydrateMenu($this->menu);
    
        $this->call_center = Cache::remember('call_center', now()->addDays(1), function(){
            $data = DB::table('text_widgets')->where('key','call_center')->first();
            return $data ? (array) $data : null;
        });
        $this->call_center = $this->call_center ? (object) $this->call_center : null;

        $this->helpline = Cache::remember('helpline', now()->addDays(1), function(){
            $data = DB::table('text_widgets')->where('key','helpline')->first();
            return $data ? (array) $data : null;
        });
        $this->helpline = $this->helpline ? (object) $this->helpline : null;

        $this->trademark = Cache::remember('trademark', now()->addDays(1), function(){
            $data = DB::table('text_widgets')->where('key','trademark')->first();
            return $data ? (array) $data : null;
          });
        $this->trademark = $this->trademark ? (object) $this->trademark : null;

        $topButtonData = Cache::remember('top_button', now()->addDays(1), function(){
            $model = TextWidget::where(['key'=>'top_button', 'active' => true])->first();
            return $model ? $model->toArray() : null;
        });
        
        if ($topButtonData) {
            $this->top_button = new TextWidget();
            $this->top_button->setRawAttributes($topButtonData, true);
            $this->top_button->exists = true;
        }

        $this->footerMenu = Cache::remember('footer_menu', now()->addDays(1), function() {
            return Menu::with(['children' => function($q){
                $q->with(['children' => function($c){
                    $c->with('page')->where('active',true)->orderBy('sort');
                }])->where('active',true)->orderBy('sort');
            }, 'parent'])->where(["active"=>true,'parent_id'=>NULL, 'position' => Menu::POSITION_FOOTER])->orderBy('sort')->get()->toArray();
        });
        $this->footerMenu = $this->hydrateMenu($this->footerMenu);
    }

    /**
     * Recursive hydration for Menu models from arrays.
     * Separates attributes from relations to prevent array-access errors in Blade.
     */
    private function hydrateMenu($data)
    {
        if (empty($data) || !is_array($data)) return collect();

        $models = [];
        foreach ($data as $itemData) {
            // Extract and remove relations from the primary data array
            $childrenData = $itemData['children'] ?? [];
            $pageData = $itemData['page'] ?? null;
            
            unset($itemData['children'], $itemData['page'], $itemData['parent']);

            // Create model and set raw attributes WITHOUT relations in them
            $model = new Menu();
            $model->setRawAttributes($itemData, true);
            $model->exists = true;

            // Set relations as proper collections/models
            $model->setRelation('children', $this->hydrateMenu($childrenData));

            if ($pageData) {
                $pageModel = new Page();
                $pageModel->setRawAttributes($pageData, true);
                $pageModel->exists = true;
                $model->setRelation('page', $pageModel);
            }

            $models[] = $model;
        }

        return collect($models);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.main',[
            'menu'=>$this->menu,
            'call_center'=>$this->call_center,
            'trademark'=>$this->trademark,
            'products'=>$this->products,
            'alumni_menu'=>$this->alumni_menu,
            'helpline'=>$this->helpline,
            'footerMenu'=>$this->footerMenu,
            'top_button'=>$this->top_button
        ]);
    }
}
