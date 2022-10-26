<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CartItemUserController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\CheckOngkirController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemRatingController;
use App\Http\Controllers\ProductCommentController;
use App\Models\Product;
use App\Models\ProductMerk;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\testController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\UserPhoneController;
use App\Http\Controllers\UserEmailController;
use App\Http\Controllers\userProfileController;
use App\Http\Controllers\UserPromoController;
use App\Models\CartItem;
use App\Models\ProductComment;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('home')->get('/', [indexController::class, 'index']);
Route::name('product')->get('/products', [ProductController::class, 'index']);
Route::name('product.show')->get('/product/{product:slug}', [ProductController::class, 'show']);
Route::name('category')->get('/category', [CategoryController::class, 'index']);
Route::name('category.show')->get('/category/{category:slug}', [CategoryController::class, 'show']);
Route::name('merk')->get('/merk', [MerkController::class, 'index']);
Route::name('merk.show')->get('/merk/{merk:slug}', [MerkController::class, 'show']);
Route::get('/users', [UserController::class, 'index']);

//login logout
Route::name('login')->get('/login', [LoginController::class, 'index'])->middleware('guest');
Route::name('login.authenticate')->post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

//forgot password
Route::name('forgot.password')->get('/forgotpassword', [ForgotPasswordController::class, 'forgotPassword'])->middleware('guest');
Route::name('forgot.password.post')->post('/forgotpassword', [ForgotPasswordController::class, 'forgotPasswordPost'])->middleware('guest');
Route::name('forgot.password.send.code')->get('/forgotpassword/sendcode', [ForgotPasswordController::class, 'forgotPasswordSendCode'])->middleware('guest');
Route::name('forgot.password.get.code')->post('/forgotpassword/sendcode', [ForgotPasswordController::class, 'forgotPasswordGetCode'])->middleware('guest');
Route::name('forgot.password.verif.code')->get('/forgotpassword/verification', [ForgotPasswordController::class, 'forgotPasswordVerification'])->middleware('guest');
Route::name('forgot.password.verif.post')->post('/forgotpassword/verification', [ForgotPasswordController::class, 'forgotPasswordVerificationPost'])->middleware('guest');
Route::name('forgot.password.reset')->get('/forgotpassword/reset', [ForgotPasswordController::class, 'forgotPasswordReset'])->middleware('guest');
Route::name('forgot.password.reset.post')->put('/forgotpassword/reset', [ForgotPasswordController::class, 'forgotPasswordResetPost'])->middleware('guest');
Route::name('forgot.password.reset.complete')->get('/forgotpassword/complete', [ForgotPasswordController::class, 'forgotPasswordResetComplete'])->middleware('guest');

// register
Route::name('register')->get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::name('register.post')->post('/register', [RegisterController::class, 'storePost']);
Route::name('register.step.one')->get('/register/step-one', [RegisterController::class, 'createStepOne']);
Route::name('register.step.one.post')->post('/register/step-one', [RegisterController::class, 'postStepOne']);
// Route::name('register.step.one')->get('/register/step-one',[RegisterController::class,'createStepOne']);
Route::name('register.step.two')->get('/register/step-two', [RegisterController::class, 'createStepTwo']);
Route::name('register.step.two.post')->post('/register/step-two', [RegisterController::class, 'postStepTwo']);
Route::name('register.step.three')->get('/register/step-three', [RegisterController::class, 'createStepThree']);
Route::name('register.step.three.post')->post('/register/step-three', [RegisterController::class, 'postStepThree']);
Route::name('register.complete')->get('/register/complete', [RegisterController::class, 'registerComplete']);

// send mail
Route::name('send.mail')->get('/send-mail', [MailController::class, 'sendMail']);

// shipment check
Route::get('/ongkir', [CheckOngkirController::class, 'index']);
Route::post('/ongkir', [CheckOngkirController::class, 'check_ongkir']);
Route::name('cities')->get('/cities/{province_id}', [CheckOngkirController::class, 'getCities']);
// Route::post('/ongkir-post', [CheckOngkirController::class, 'check_ongkir']);

// cart items
Route::name('update.quantity')->post('/updatequantity', [CartItemUserController::class, 'update_quantity'])->middleware('auth');
Route::name('update.sender.address')->post('/updatesenderaddress', [CartItemUserController::class, 'update_sender_address'])->middleware('auth');
Route::name('get.update.quantity')->get('/getupdatequantity', [CartItemUserController::class, 'get_update_quantity'])->middleware('auth');
Route::name('cart.destroyall')->post('/cartdeleteall', [CartItemUserController::class, 'destroy_all'])->middleware('auth');
Route::name('carts.destroy')->post('/carts', [CartItemUserController::class, 'deleteCartItem'])->middleware('auth');
Route::resource('/cart', CartItemUserController::class)->middleware('auth');

// checkout
Route::name('buy.now')->post('/buynow', [CartItemUserController::class, 'buyNow'])->middleware('auth');
Route::name('buy.now.view')->get('/buynow', [CartItemUserController::class, 'buyNowView'])->middleware('auth');
Route::name('cart.checkout')->post('/checkout', [CartItemUserController::class, 'checkout'])->middleware('auth');
Route::name('cart.checkout.view')->get('/checkout', [CartItemUserController::class, 'checkoutView'])->middleware('auth');
Route::name('checkout.promo.post')->post('/checkoutpromo', [CartItemUserController::class, 'checkoutPromoPost'])->middleware('auth');
Route::name('checkout.promo.get')->get('/checkoutpromo', [CartItemUserController::class, 'checkoutPromoGet'])->middleware('auth');

// checkout
Route::name('checkout.payment')->post('/payment', [CartItemUserController::class, 'payment'])->middleware('auth');
Route::name('checkout.payment.view')->get('/payment', [CartItemUserController::class, 'paymentView'])->middleware('auth');

//user notification
Route::name('read.all.notifications')->post('/user/account/readallnotifications', [UserNotificationController::class,'allNotificationsIsReaded'])->middleware('auth');
Route::resource('/user/account/notifications', UserNotificationController::class)->middleware('auth');

//user Promo
Route::resource('/user/account/promo', UserPromoController::class)->except(['edit','update','destroy'])->middleware('auth');

//user address
Route::name('useraddress.change.active')->post('/changeaddress', [UserAddressController::class, 'changeAddress'])->middleware('auth');
Route::resource('/user/account/useraddress', UserAddressController::class)->middleware('auth');

//reset password
Route::name('change.password')->get('/user/account/password', [ChangePasswordController::class, 'changePassword'])->middleware('auth');
Route::name('change.password.post')->post('/user/account/password', [ChangePasswordController::class, 'changePasswordPost'])->middleware('auth');

//user profile
Route::name('profile.image.upload')->post('/user/account/profile-image-upload', [userProfileController::class, 'uploadProfileImage'])->middleware('auth');
Route::name('profile.image.delete')->post('/user/account/profile-image-delete', [userProfileController::class, 'deleteProfileImage'])->middleware('auth');
Route::resource('/user/account/profile', userProfileController::class)->middleware('auth');

//user phone - add
Route::name('profile.add.phone')->get('/user/account/add-phone', [UserPhoneController::class, 'addPhone'])->middleware('auth');
Route::name('profile.add.phone.post')->post('/user/account/add-phone', [UserPhoneController::class, 'addPhonePost'])->middleware('auth');
Route::name('profile.add.phone.req.verify.method')->get('/user/account/add-phone-req-verify-method', [UserPhoneController::class, 'addPhoneReqVerifyMethod'])->middleware('auth');
Route::name('profile.add.phone.send.verify.method')->post('/user/account/add-phone-req-verify-method', [UserPhoneController::class, 'addPhoneSendVerifyMethod'])->middleware('auth');
Route::name('profile.add.phone.verify')->get('/user/account/add-phone-verify', [UserPhoneController::class, 'addPhoneVerify'])->middleware('auth');
Route::name('profile.add.phone.verify.submit')->post('/user/account/add-phone-verify', [UserPhoneController::class, 'addPhoneVerifySubmit'])->middleware('auth');
Route::name('profile.add.phone.verified')->get('/user/account/add-phone-verified', [UserPhoneController::class, 'addPhoneVerified'])->middleware('auth');
Route::name('profile.add.phone.clear.session')->get('/user/account/add-phone-clear-session', [UserPhoneController::class, 'addPhoneClearSession'])->middleware('auth');

//user phone - update
Route::name('profile.update.phone')->get('/user/account/update-phone', [UserPhoneController::class, 'updatePhone'])->middleware('auth');
// Route::name('profile.update.phone.post')->post('/user/account/update-phone',[UserPhoneController::class,'updatePhonePost'])->middleware('auth');
// Route::name('profile.update.phone.req.verify.method')->get('/user/account/update-phone-req-verify-method',[UserPhoneController::class,'updatePhoneReqVerifyMethod'])->middleware('auth');
Route::name('profile.update.phone.send.verify.method.first')->post('/user/account/update-phone-req-verify-method', [UserPhoneController::class, 'updatePhoneSendVerifyMethodFirst'])->middleware('auth');
Route::name('profile.update.phone.verify.first')->get('/user/account/update-phone-verify-first', [UserPhoneController::class, 'updatePhoneVerifyFirst'])->middleware('auth');
Route::name('profile.update.phone.verify.submit.first')->post('/user/account/update-phone-verify-first', [UserPhoneController::class, 'updatePhoneVerifySubmitFirst'])->middleware('auth');
Route::name('profile.update.phone.verified.first')->get('/user/account/update-phone-verified-first', [UserPhoneController::class, 'updatePhoneVerifiedFirst'])->middleware('auth');
Route::name('profile.update.phone.clear.session.first')->get('/user/account/update-phone-clear-session', [UserPhoneController::class, 'updatePhoneClearSessionFirst'])->middleware('auth');
Route::name('profile.update.phone.fill.new')->get('/user/account/update-phone-fill', [UserPhoneController::class, 'updatePhoneFillNew'])->middleware('auth');

//user email - add
Route::name('profile.add.email')->get('/user/account/add-email', [UserEmailController::class, 'addEmail'])->middleware('auth');
Route::name('profile.add.email.post')->post('/user/account/add-email', [UserEmailController::class, 'addEmailPost'])->middleware('auth');
Route::name('profile.add.email.req.verify.method')->get('/user/account/add-email-req-verify-method', [UserEmailController::class, 'addEmailReqVerifyMethod'])->middleware('auth');
Route::name('profile.add.email.send.verify.method')->post('/user/account/add-email-req-verify-method', [UserEmailController::class, 'addEmailSendVerifyMethod'])->middleware('auth');
Route::name('profile.add.email.verify')->get('/user/account/add-email-verify', [UserEmailController::class, 'addEmailVerify'])->middleware('auth');
Route::name('profile.add.email.verify.submit')->post('/user/account/add-email-verify', [UserEmailController::class, 'addEmailVerifySubmit'])->middleware('auth');
Route::name('profile.add.email.verified')->get('/user/account/add-email-verified', [UserEmailController::class, 'addEmailVerified'])->middleware('auth');
Route::name('profile.add.email.clear.session')->get('/user/account/add-email-clear-session', [UserEmailController::class, 'addEmailClearSession'])->middleware('auth');

//user email - update
Route::name('profile.update.email')->get('/user/account/update-email', [UserEmailController::class, 'updateEmail'])->middleware('auth');
// Route::name('profile.update.email.post')->post('/user/account/update-email',[UserEmailController::class,'updateEmailPost'])->middleware('auth');
// Route::name('profile.update.email.req.verify.method')->get('/user/account/update-email-req-verify-method',[UserEmailController::class,'updateEmailReqVerifyMethod'])->middleware('auth');
Route::name('profile.update.email.send.verify.method.first')->post('/user/account/update-email-req-verify-method', [UserEmailController::class, 'updateEmailSendVerifyMethodFirst'])->middleware('auth');
Route::name('profile.update.email.verify.first')->get('/user/account/update-email-verify-first', [UserEmailController::class, 'updateEmailVerifyFirst'])->middleware('auth');
Route::name('profile.update.email.verify.submit.first')->post('/user/account/update-email-verify-first', [UserEmailController::class, 'updateEmailVerifySubmitFirst'])->middleware('auth');
Route::name('profile.update.email.verified.first')->get('/user/account/update-email-verified-first', [UserEmailController::class, 'updateEmailVerifiedFirst'])->middleware('auth');
Route::name('profile.update.email.clear.session.first')->get('/user/account/update-email-clear-session', [UserEmailController::class, 'updateEmailClearSessionFirst'])->middleware('auth');
Route::name('profile.update.email.fill.new')->get('/user/account/update-email-fill', [UserEmailController::class, 'updateEmailFillNew'])->middleware('auth');

//order
// delete order
Route::name('order.delete')->post('/order-delete/{order}', [OrderController::class, 'deleteOrder'])->middleware('auth');
Route::name('order.cancellation.request')->post('/order-cancellation-request/{order}', [OrderController::class, 'orderCancellationRequest'])->middleware('auth');
// download order proof of payment
Route::name('order.detail.proof.of.payment.download')->post('/order/detail/proof-pf-payment-download', [OrderController::class, 'downloadProofOfPayment'])->middleware('auth');
// order proof of payment
Route::name('order.detail.proof.of.payment')->post('/order/detail/proof-pf-payment', [OrderController::class, 'orderDetailProofOfPayment'])->middleware('auth');
// show canceled order
// Route::name('order.detail.canceled')->get('/order/detail/{id}',[OrderController::class,'orderCanceledDetail'])->middleware('auth');
// detail order
Route::name('order.detail')->get('/order/detail', [OrderController::class, 'orderDetail'])->middleware('auth');
Route::name('order.detail.bind')->get('/order/detail/{id}', [OrderController::class, 'orderDetailBind'])->middleware('auth');
Route::name('order.detail.product')->get('/order/detail/{id}/product/{orderItem:id}', [OrderController::class, 'orderProductDetail'])->middleware('auth');
// payment completed
Route::name('payment.completed')->post('/order/payment-completed', [OrderController::class, 'paymentCompleted'])->middleware('auth');
// reupload payment
Route::name('payment.reupload')->post('/order/payment-reupload', [OrderController::class, 'paymentReupload'])->middleware('auth');
// payment order
Route::name('payment.order.bind')->get('/order/payment/{id}', [OrderController::class, 'paymentOrderBind'])->middleware('auth');
Route::name('payment.order')->get('/order/payment', [OrderController::class, 'paymentOrder'])->middleware('auth');
// Route::name('order.waiting.payment')->get('/order-waiting-for-payment', [OrderController::class, 'confirmOrder'])->middleware('auth');
// confirm order
Route::name('confirm.order')->post('/order/confirm-order', [OrderController::class, 'confirmOrder'])->middleware('auth');
// order resource
Route::resource('/order', OrderController::class)->middleware(('auth'))->except(['edit', 'update']);

Route::resource('/rating', OrderItemRatingController::class)->middleware(('auth'));
Route::resource('/comment', ProductCommentController::class)->middleware(('auth'));

Route::name('TEST')->get(
    '/test',
    [testController::class, 'index']
);

// admin
Route::prefix('administrator')->group(function () {
    Route::name('administrator')->get('/', [Admin\HomeController::class, 'index']);
    Route::name('admin.login')->get('/login', [Admin\Auth\LoginController::class, 'index']);
    Route::name('admin.login.post')->post('/login', [Admin\Auth\LoginController::class, 'login']);
    Route::name('admin.test')->get('/test', [Admin\HomeController::class, 'test']);
    Route::name('admin.logout.get')->get('/logout', [Admin\Auth\LoginController::class, 'logoutGet']);
    Route::name('admin.logout')->post('/logout', [Admin\Auth\LoginController::class, 'logout']);

    Route::name('admin.home')->get('/', [Admin\HomeController::class, 'index']);

    Route::name('admin.product.check.slug')->get('/adminproduct/checkSlug', [Admin\AdminProductController::class, 'checkSlug']);
    Route::name('admin.product.delete.image')->post('/adminproduct/deleteproductimage', [Admin\AdminProductController::class, 'deleteProductImage']);
    Route::name('admin.product.update.status')->post('/adminproduct/updatestatus', [Admin\AdminProductController::class, 'updateStatus']);
    Route::name('admin.product.update.status.notification')->post('/adminproduct/updatestatusstocknotification', [Admin\AdminProductController::class, 'updateStatusStockNotification']);
    Route::name('admin.product.out.stock')->get('/adminproduct/outstock', [Admin\AdminProductController::class, 'outStock']);
    Route::name('admin.product.comment')->get('/adminproduct/product-comment', [Admin\AdminProductController::class, 'productComment']);
    Route::resource('/adminproduct', Admin\AdminProductController::class)->parameters(['adminproduct' => 'product:slug']);

    Route::name('admin.category.check.slug')->get('/admincategory/checkSlug', [Admin\AdminCategoryController::class, 'checkSlug']);
    Route::resource('/admincategory', Admin\AdminCategoryController::class);

    Route::name('admin.merk.check.slug')->get('/adminmerk/checkSlug', [Admin\AdminMerkController::class, 'checkSlug']);
    Route::resource('/adminmerk', Admin\AdminMerkController::class);

    Route::name('adminorder.detail.bind')->get('/adminorder/detail/{id}', [Admin\AdminOrderController::class, 'orderDetailBind'])->middleware('adminMiddle');
    Route::name('adminorder.detail.proof.of.payment.download')->post('/adminorder/detail/proof-pf-payment-download', [Admin\AdminOrderController::class, 'downloadProofOfPayment']);
    // order proof of payment
    Route::name('adminorder.detail.proof.of.payment')->post('/adminorder/detail/proof-pf-payment', [Admin\AdminOrderController::class, 'orderDetailProofOfPayment']);
    Route::name('confirm.payment')->post('/adminorder/confirm-payment', [Admin\AdminOrderController::class, 'confirmPayment']);
    Route::name('prepare.order')->post('/adminorder/prepare-order', [Admin\AdminOrderController::class, 'prepareOrder']);
    Route::name('delive.order')->post('/adminorder/delive-order', [Admin\AdminOrderController::class, 'deliveOrder']);
    Route::name('decline.payment')->post('/adminorder/decline-payment', [Admin\AdminOrderController::class, 'declinePayment']);
    Route::name('shipping.receipt.upload')->post('/adminorder/shipping-receipt-upload', [Admin\AdminOrderController::class, 'shippingReceiptUpload']);
    Route::resource('/adminorder', Admin\AdminOrderController::class)->middleware('adminMiddle');

    Route::name('admin.update.sender.address')->post('/senderaddress/updatestatus', [Admin\SenderAddressController::class, 'update_status'])->middleware('adminMiddle');
    Route::resource('/senderaddress', Admin\SenderAddressController::class)->middleware('adminMiddle');

    Route::name('admin.payment.update.status')->post('/paymentmethod/updatestatus', [Admin\AdminPaymentMethodController::class, 'updateStatus'])->middleware('adminMiddle');
    Route::resource('/paymentmethod', Admin\AdminPaymentMethodController::class)->middleware('adminMiddle');
    
    Route::name('admin.income')->get('/incomes', [Admin\AdminIncomeController::class, 'index'])->middleware('adminMiddle');


    Route::resource('/promobanner', Admin\AdminPromoBannerController::class)->middleware('adminMiddle');

    Route::name('admin.promo.voucher.update.status')->post('/promovoucher/updatestatus', [Admin\AdminPromoVoucherController::class, 'updateStatus']);
    Route::name('admin.promo.voucher.code.check')->post('/promovoucher/promocodecheck', [Admin\AdminPromoVoucherController::class, 'PromoCodeCheck']);
    Route::name('admin.promo.voucher.delete.image')->post('/promovoucher/deleteimage', [Admin\AdminPromoVoucherController::class, 'deleteImage']);
    Route::resource('/promovoucher', Admin\AdminPromoVoucherController::class)->middleware('adminMiddle');

    Route::name('productcomment.reply')->get('/productcomment/reply/{comment}', [Admin\AdminProductCommentController::class, 'commentReply'])->middleware('adminMiddle');
    Route::resource('/productcomment', Admin\AdminProductCommentController::class)->middleware('adminMiddle');
    Route::name('my.comment.index')->get('/mycomment', [Admin\AdminReplyCommentController::class,'index'])->middleware('adminMiddle');
    // finance-admin
    Route::prefix('finance')->group(function () {
        Route::name('finance.home')->get('/', [Admin\Finance\FinanceHomeController::class, 'index']);
    });
    Route::prefix('warehouselogistic')->group(function () {
        Route::name('warehouselogistic.home')->get('/', [Admin\WarehouseLogistic\WarehouseLogisticHomeController::class, 'index']);
    });
});
