<?php

namespace Modules\WebNav\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use \App\Illuminate\Routing\ModuleController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
class WebNavController extends \App\Http\Controllers\Controller
{
    public function view_meta($idOrSlug = null)
    {
        $id = $idOrSlug;
        if (is_numeric($idOrSlug)) {
        }
        $return = [
            'metas' => \App\Models\Meta::with([
                'children' => function (HasMany $query) {
                    $query->where('type', 'category');
                },
                'contents'
            ])
                ->where('type', 'category')
                ->where("parent", $id)
                ->whereNull('deleted_at')
                ->get(),
            'contents' => \App\Models\Meta::with(['contents'])->find($this->moduleMeta->id)->contents,
        ];
        // dump($return);
        return $this->view('index', $return);
    }
    public function crud_index($idOrSlug = null)
    {
        // var_dump(request()->all());
        switch (request()->input('_target')) {
            case "insert_meta_item":
                $meta = (new \App\Models\Meta(request()->all()));
                $meta->save();
                break;
            case "delete_meta_item":
                $meta = \App\Models\Meta::find(request()->input('id'));
                $meta->timestamps = false;
                $meta->update(['deleted_at' => now()]);
                \App\Models\Relationship::where('meta_id', request()->input('id'))->delete();
                break;
            case "update_meta_item":
                $meta = \App\Models\Meta::find(request()->input('id'));
                $meta->fill(request()->all());
                $meta->save();
                break;
            case "insert_content_item":
                $content = (new \App\Models\Content(request()->all()));
                $content->save();
                $ids = request()->input('ids');
                if (is_string($ids)) {
                    $ids = explode(',', $ids);
                }
                foreach ($ids as $id) {
                    \App\Models\Relationship::upsert([
                        "content_id" => $content->id,
                        "meta_id" => $id,
                    ], ['content_id', 'meta_id']);
                }
                // var_dump($ids);
                // var_dump($content);
                break;
            case "delete_content_item":
                $content = \App\Models\Content::find(request()->input('id'));
                $content->timestamps = false;
                $content->update(['deleted_at' => now()]);
                \App\Models\Relationship::where('content_id', request()->input('id'))->delete();
                break;
            case "update_content_item":
                $content = \App\Models\Content::find(request()->input('id'));
                $content->fill(request()->all());
                $content->save();
                break;
            default:
                break;
        }
        return $this->view_index($idOrSlug);
    }
}
