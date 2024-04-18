<?php

use App\Models\Country;
use App\Models\Coupon;
use App\Models\ScratchGame;
use App\Models\ScratchGameUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Setting;


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

Route::get('fill',function(){
    $ar = 'الأفراد ("المستخدم") الذين يزورون و / أو يستخدمون موقع الويب ("(موقع الويب") على عنوان "defacto.com" وتطبيقات الهاتف المحمول "DeFacto" ("تطبيق الجوّال")، التي تديرها شركة ديفاكتو للبيع بالتجزئة المحدودة (ذ.م.م) DEFACTO Egypt for Trade ("الشركة") يتعين عليهم قراءة سياسة الخصوصية هذه قبل استخدام الموقع الإلكتروني وتطبيقات الجوال.

    1. يتم طلب بعض البيانات الشخصية (الاسم والعمر وعنوان البريد الإلكتروني، وما إلى ذلك) في الموقع الإلكتروني وتطبيقات الجوال من أجل خدمة المستخدمين بشكل أفضل. يتم استخدام هذه البيانات التي يتم جمعها من خلال موقع الويب وتطبيقات الجوال داخل موقع الويب وتطبيقات الجوال من أجل توفير القدرة على إجراء دراسات الحملات أو أنشطة الترويج الخاصة التي تستهدف حساب المستخدم. بصرف النظر عن البيانات الشخصية؛ يتم تحليل البيانات الإحصائية للمعاملات التي تتم من خلال موقع الويب أو تطبيق الهاتف المحمول وفقا لأحكام القانون 09.08 المتعلق بحماية الأفراد فيما يتعلق بمعالجة البيانات الشخصية.

    2. لا تتقاسم الشركة ابدا البيانات المرسلة إليها من خلال نماذج العضوية مع أطراف ثالثة، بخلاف علم المستخدمين أو ما لم تكن لديهم أي تعليمات على عكس ذلك، كما لا تستخدم هذه البيانات أو تقوم ببيعها  لأي أغراض تجارية بسبب أي أسباب غير ذات صلة.

    3. تُستخدم ميزات "إعادة التسويق والديمغرافيا والإبلاغ عن مجال الاهتمام" في تحليلات جوجل Google Analytics في محتويات موقع الويب. قد يتم استبعاد الإعلانات المرئية من نطاق تحليلات جوجل وقد يتم تخصيص إعلانات شبكة إعلانات جوجل المرئية باستخدام إعدادات الإعلان. تُستخدم البيانات الديموغرافية التي توفرها تحليلات جوجل لتخصيص موقع الويب والإعلانات على موقع الويب، إن وجدت، وفقا لمجالات اهتمام المستخدمين. يمكن مشاركة هذه البيانات مع ناشري الإعلانات، جنبا إلى جنب مع بيانات المستخدمين الآخرين حيث يكون ذلك أثناء استخدامها في الدراسات الجماهيرية المستهدفة. لا تتضمن هذه البيانات أي بيانات شخصية (الاسم واللقب ورقم الهوية الوطنية والجنس والعمر وما إلى ذلك) بأي طريقة؛ حيث يتم استخدامها لإجراء دراسات بشأن اتجاهات المستخدم وتجميع الكتلة المستهدفة. تتم الموافقة على مشاركة البيانات مجهولة المصدر مع ناشري الإعلانات لأغراض الإعلان والترويج عند قبول اتفاقية الاستخدام هذه.

    4. يجب على مزودي الطرف الثالث، بما في ذلك جوجل، عرض إعلانات موقع الويب وتطبيقات الجوال في مناطق الشعارات التي يقدمونها في مواقع الناشرين على الإنترنت. يتم استخدام الكوكيز الطرف الأول والكوكيز الطرف الثالث بشكل جماعي بواسطة موقع الويب وموفري الطرف الثالث، بما في ذلك جوجل وذلك لجمع المعلومات المتعلقة بالإعلانات ولتحسين الإعلانات ونشرها على أساس الزيارات السابقة لزوار الموقع الإلكتروني وتطبيقات الجوال.

    5. يتم الكشف عن بيانات المستخدم الشخصية للسلطات العامة فقط في ظل الظروف التي قد يطلب فيها ذلك كأمر من المحكمة ويكون هذا الكشف إلزاميا وفقا لأحكام التشريعات الإلزامية.

    6. لا يتم الاحتفاظ ببيانات بطاقة ائتمان المستخدم المطلوبة في صفحة الدفع على خوادم موقع الويب والجوال أو شركات مزودي خدمة الطرف الثالث من أجل الحفاظ على أمان المستخدمين الذين يشترون من موقع الويب و / أو تطبيق الجوال على أعلى تقدير. وبالتالي يتم التأكد من تحقيق جميع المعاملات التي تهدف إلى الدفع بين البنك ذي الصلة والجهاز المستخدم من قبل المستخدم، من خلال واجهة الموقع الإلكتروني وتطبيقات الجوال.

    7. من خلال الموافقة على اتفاقية الاستخدام هذه، يؤكد المستخدم أن البيانات التي شاركها مع الشركة هي بياناته الشخصية وقد تتم مشاركة هذه البيانات مع كيانات قانونية أخرى تابعة للشركة حتى تكون قادرة على تنفيذ المبيعات وأنشطة التسويق وتقديم إخطار مناسب لأي أجهزة اتصال.
     8. من الممكن دائما إزالتك من قائمة إرسال البريد الإلكتروني بالنقر فوق عبارة "الرجاء النقر إذا كنت لا تريد أن تكون على علم بإعلانات الحملة ". حيث يتواجد رابط في أسفل رسائل البريد الإلكتروني المرسلة في نطاق عضوية الموقع أو عن طريق ترك الخيار "أرغب في الاطلاع على الحملات والفرص" فارغا في حقل "تحديث بيانات العضوية" في قسم "حسابي" في الموقع الالكتروني.

    9. يوافق العضو صراحة على معالجة بياناته الشخصية ونقلها إلى أطراف ثالثة في إطار احترام  القوانين في المغرب وكما هو مشمول بالقانون المدني. يجب أن تتم معالجة البيانات الشخصية طالما استمرت العضوية.

    10. مشرف البيانات هو شركة ديفاكتو للبيع بالتجزئة المحدودة (ذ.م.م) DEFACTO Egypt for Trade بموجب القانون ويقبل الامتثال لجميع التزاماته بموجب القانون.

    11. تتم معالجة البيانات الشخصية للعضو من أجل تقديم تجربة تسوق أفضل، بالإضافة الى جمع البيانات الإحصائية وتجميعها، وتحسين الأنشطة التجارية والوفاء بالالتزامات التي ينص عليها اتفاق العضوية مع الشركة وأغراض مماثلة.

    12. يقبل العضو ويعلن ويتعهد بأنه وافق صراحة على إرسال بياناته الشخصية إلى أطراف ثالثة يحددها المستخدم، محليا أو خارجيا، من أجل الاحتفاظ بهذه البيانات وتخزينها ومعالجتها لأي أغراض .

    13. يتم جمع البيانات الشخصية للعضو من خلال نموذج الطلب أو على الوسائط الإلكترونية، إذا لزم الأمر.

    14. في أي وقت، يحق للعضو التقدم إلى شركة مشرف البيانات بموجب القانون لمعرفة ما إذا كانت بياناته الشخصية قد تمت معالجتها أم لا، أو لطلب معلومات حول بياناته الشخصية المعالجة - إن وجدت، ومعرفة الغرض من معالجة البيانات الشخصية وما إذا كانت هذه البيانات قد تم استخدامها على النحو المناسب لهذه الأغراض أم لا، أو معرفة الأطراف الثالثة التي تم إرسال بياناته الشخصية إليها، او طلب تصحيح الأخطاء في بياناته الشخصية، وإذا تم إرسالها، يمكنه المطالبة بالتصحيح من أطراف ثالثة ذات صلة، أو طلب حذف بياناته أو إتلافها أو تعميم هويتها عند إزالة الأسباب التي تستلزم معالجة البيانات الشخصية، وفي حالة إرسالها، يمكنه المطالبة بإبلاغ هذا الطلب إلى الطرف الثالث الذي تم نقل بياناته إليه، كما يكون لديه الحق في الطعن في النتيجة السلبية التي تتعلق بالفرد والتي تكون ناتجة عن معالجة البيانات، أو المطالبة بالتعويض عن الأضرار بموجب القوانين في حالة تكبد أي أضرار نتيجة لمعالجة البيانات بشكل مخالف للقانون.

    ';



    $en = "Individuals ('User') who visit and/or use the website (the (“Website”) at the “defacto.com ” address and the “Defacto” mobile application (the “Mobile App”), operated by DEFACTO Egypt for trade. (the “Company”) are required to read this Confidentiality Policy prior to using the Website and the Mobile App.



    Certain personal data (name, age, e-mail address, etc.) are requested at the Website and Mobile App in order to serve the Users better. Such data collected through the Website and Mobile App are used within the Website and Mobile App in order to be able to carry out campaign studies or special promotion activities aimed for the User's account. Apart from the personal data; statistical data of the transactions made through the Website or Mobile App are analyzed and retained.
    The Company absolutely does not share the data communicated to it by membership forms with third parties, outside of the Users' knowledge or unless they have any instructions on the contrary, and does not use and sell such data for any commercial purposes due to any unrelated reasons.
    The Re-Marketing & Demography and Field of Interest Reporting features of Google Analytics are used in the contents of the Website. Visual Advertising may be excluded from the scope of Google Analytics and the Google Visual Advertising Network advertisements may be customized using the advertisement settings. The Demographic data provided by Google Analytics are used to customize the Website and the advertisements on the Website, if any, according to the fields of interest of the Users. Such data may be shared with advertisement publishers, together with the data of other Users, while they are being used in target mass studies. Such data do not include any personal data (name, surname, National Identification No., gender, age, etc.) in any ways; they are used to make studies regarding User trends and compile the target mass. The sharing of anonymous data with advertisement publishers for advertisement and promotion purposes is approved upon accepting this Use Agreement.
    Third party providers, including Google, shall display the Website and Mobile App advertisements in the banner areas they provide at the publisher sites on the internet. First party cookies and third party cookies are collectively used by the Website and third party providers, including Google, to collect information regarding the advertisements, and to optimize and publish the advertisements as based on the past visits of the visitors to the Website and Mobile App.
    Personal User data shall be disclosed to public authorities solely under circumstances where they are demanded by court order and such disclosure is compulsory as per the mandatory legislation provisions.
    The User credit card data requested on the payment page are not kept on the servers of the Website and Mobile or third party service provider companies in order to maintain the security of Users who purchase from the Website and/or Mobile App at the highest level. Thus, it is ensured that all transactions aimed for payment are realized between the related bank and the device used by the User, through the Website and Mobile App interface.
    By approving this Use Agreement, the User confirms that the data he has shared with the Company are his personal data and such data may be shared with other legal entities that are affiliates of the Company in order to be able to carry out sales and marketing activities and provide proper notification to any communication devices.
    It is always possible to be removed from the e-mail sending list by clicking the Please click if you do not want to be informed about the campaign announcements. link at the bottom of the e-mails sent within the scope of Website membership or by leaving the I would like to be informed about campaigns and opportunities option blank in the Update Membership Data field in My Account section on the Website.
    The Member expressly consents for his personal data to be processed and transmitted to third parties within the scope of the Laws in Egypt and as covered under the Civil Code. Personal data shall continue to be processed as long a membership is continued.
    The Data Supervisor is DEFACTO Egypt for Trade under the Law and accepts to comply with all its liabilities and obligations in the Law.
    The personal data of the Member are processed in order to offer a better shopping experience, collect and compile statistical data, improve commercial activities and fulfill the liabilities that the membership agreement encumbers the Company with and similar purposes.
    The Member accepts, declares and undertakes that he has expressly consented to the transmission of his personal data to third parties to be determined by the User, domestically or abroad, in order for such data to be retained, stored and processed for any purposes.
    The Personal Data of the Member are collected through this application form or on electronic media, if deemed necessary.
    At any time, the Member is entitled to apply to the Data Supervisor Company under the Law and find out whether his personal data have been processed or not, request information about his processed personal data – if any, find out about the purpose of processing personal data and whether such data have been use as fit for such purposes or not, know the third parties to whom his personal data have been transmitted, request the correction of errors in his personal data and, if transmitted, request such correction to be demanded from the related third parties, request his data to be deleted, destroyed or anonymized upon the elimination of causes necessitating the processing of personal data and, if transmitted, to ask for this request to be communicated to the third party to whom they have been transmitted, challenge a negative result related with the individual as a result of processed data, claim damages under the laws in case any damages are incurred due to processing of data as contrary to the Law.
    ";


    $data = [
        'en' => $en,
        'ar' => $ar
    ];
    $data= json_encode($data);
    Setting::set('policy' , $data);
    Setting::save();
    dd('success');

});

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('test', function(){
    $countries = Country::get();
    foreach($countries as $country){
            Coupon::where('country_id', $country->id)
                    ->where('expiration_date', '<', Carbon::today($country->timezone))
                    ->update([
                        'status' => 'expired',
                    ]);
    }
});
