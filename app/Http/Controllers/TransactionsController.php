<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends BaseController
{
    const PER_PAGE = 10;

    protected $sourceService;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $validationResult = $this->validateRequest($request);
        if (!$validationResult['result']) {
            return response()->json($validationResult, 200);
        }
        $this->setSourceService($request->get('source'));
        $data = $this->paginate()->appends(request()->except('page'));

        return response()->json($data, 200);
    }

    /**
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return Paginator
     */
    public function paginate($perPage = self::PER_PAGE, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = app($this->sourceService)->get($perPage, $perPage * ($page - 1));
        $paginator = new Paginator($items, $perPage, $page, $options);
        $paginator->hasMorePagesWhen();
        $paginator->setPath(url()->current());

        return $paginator;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function validateRequest(Request $request): array
    {
        $sources = array_keys(config('source.type'));
        $rules = [
            'source' => ['required', Rule::in($sources)]
        ];

        $validator = Validator::make($request->all(), $rules);

        $validation['result'] = true;
        if ($validator->fails()) {
            $validation['result'] = false;
            $validation['message'] = $validator->messages();
        }

        return  $validation;
    }

    /**
     * @param string $source
     */
    protected function setSourceService(string $source)
    {
        $confidData = config('source.type.' . $source);

        $this->sourceService = $confidData['serviceName'];
    }
}
