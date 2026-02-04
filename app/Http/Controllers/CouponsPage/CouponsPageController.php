<?php

namespace App\Http\Controllers\CouponsPage;

use App\Models\CouponsPage;
use App\Http\Controllers\Controller;
use App\Models\CouponsPageSetting;
use Illuminate\Http\Request;
use Bigcommerce\Api\Client as Bigcommerce;
use App\Models\Credential;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Exception;
use Throwable;
class CouponsPageController extends Controller
{ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($site)
    {
        //
        $couponspage = CouponsPage::where('site' ,$site )->orderBy('sort','asc')->get();
        $couponspagesetting = CouponsPageSetting::where('site' ,$site )->first();
        return view('couponspage.list', [ 'site' => $site , 'couponspage' => $couponspage , 'couponspagesettings' => $couponspagesetting]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($site)
    {
        //
        return view('couponspage.add',['site' => $site] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($site, Request $request)
    {
        //
        $data = $request->except('_token');
        $data['is_active'] = $data['is_active'] ? true : false;
        $tbCoupon = CouponsPage::create($data);
        $tbCoupon->save();
        return  redirect()->route('couponspage.index',['site' => $site])->withStatus('Added successfully');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CouponsPage  $couponsPage
     * @return \Illuminate\Http\Response
     */
    public function show(CouponsPage $couponsPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CouponsPage  $couponsPage
     * @return \Illuminate\Http\Response
     */
    public function edit($site,CouponsPage $couponsPage)
    {
        //
        return view('couponspage.edit')->with(['site'=>$site,'couponspage'=>$couponsPage]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CouponsPage  $couponsPage
     * @return \Illuminate\Http\Response
     */
    public function update($site, Request $request, CouponsPage $couponsPage)
    {
        //
        $couponsPage->fill($request->except('_token'))->save();
        return  redirect()->back()->withStatus('Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CouponsPage  $couponsPage
     * @return \Illuminate\Http\Response
     */
    public function destroy($site,CouponsPage $couponsPage)
    {
        //
        $couponsPage->delete();
        return redirect()->back()->withStatus('Deleted successfully');

    }

    function customRender($__php, $__data)
    {
        $__data['__env'] = app(\Illuminate\View\Factory::class);

        $obLevel = ob_get_level();
        ob_start();
        extract($__data, EXTR_SKIP);
        try {
            eval('?' . '>' . $__php);
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw $e;
        } catch (Throwable $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw new FatalThrowableError($e);
        }
        return ob_get_clean();
    }

    public function pushChangesToBc( $site, $id,Request $request){
        // Find origin from which request is made

        $couponspage = CouponsPage::where('site' ,$site )->where('is_active' , 1 )->orderBy('sort','asc')->take(3)->get();

        $credential = Credential::where('site', $site)->first(['client_id','access_token','store_hash']);

        Bigcommerce::configure([
            'client_id' => $credential->client_id,
            'auth_token'=> $credential->access_token,
            'store_hash'=> $credential->store_hash,
        ]);

        $couponspagesetting = CouponsPageSetting::find($id);
        $php = Blade::compileString($couponspagesetting->body);
        $page_html = $this->customRender($php, ['couponspage'=> $couponspage]);

        Bigcommerce::failOnError();

        try {
            $pages = Bigcommerce::updatePage($couponspagesetting->page_id, array('body'=>$page_html));

        } catch(\Bigcommerce\Api\Error $error) {
            $code = $error->getCode();
            $msg = $error->getMessage();
            return redirect()->back()->withStatus("Error $code, $msg");
        }

        return redirect()->back()->withStatus("Succesfully pushed to Bigcommerce");
   }
}
