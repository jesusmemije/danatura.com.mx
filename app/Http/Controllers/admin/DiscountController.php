<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Rule;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $coupons = Coupon::all();
        $rule = Rule::find(1);

        return view('admin.discounts.index', compact('coupons', 'rule'));
    }

    public function createCoupon()
    {
        return view('admin.discounts.create');
    }

    public function storeCoupon(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:coupons|max:20',
        ],
        [
            'codigo.unique' => 'Este código ya ha sido utilizado, intenta con otro por favor.',
            'codigo.max' => 'El código no debe tener más de 20 caracteres.',
        ]);

        Coupon::create($request->all());

        return redirect()->route('discounts.index')->with('status', 'El cupón se ha creado con éxito');
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.discounts.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $coupon->titulo = $request->titulo;
        $coupon->tipo = $request->tipo;
        $coupon->cantidad = $request->cantidad;
        $coupon->status = $request->status;
        $coupon->save();

        return redirect()->route('discounts.index')->with('status', 'El cupón se ha editado con éxito');
    }

    public function destroyCoupon($id)
    {
        Coupon::destroy($id);
        return redirect()->route('discounts.index')->with('status', 'El cupón se ha eliminado con éxito');
    }

    public function updateRuleEnvio(Request $request, Rule $rule)
    {
        $rule->cantidad = $request->cantidad;
        $rule->save();

        return redirect()->route('discounts.index')->with('status_rule', 'La regla de envío se ha editado con éxito');
    }

}
