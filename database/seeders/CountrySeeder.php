<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use DB;
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run()
    {
        DB::table('countries')->insert([
            ['name' => 'أبخازيا','is_active'=>1],                   
            ['name' => 'أفغانستان','is_active'=>1],                 
            ['name' => 'جزر آلاند','is_active'=>1],                  
            ['name' => 'ألبانيا','is_active'=>1],                   
            ['name' => 'الجزائر','is_active'=>1],                   
            ['name' => 'ساموا الأمريكية','is_active'=>1],            
            ['name' => 'أندورا','is_active'=>1],                    
            ['name' => 'أنغولا','is_active'=>1],                     
            ['name' => 'أنغيلا','is_active'=>1],                     
            ['name' => 'أنتيغوا باربودا','is_active'=>1],           
            ['name' => 'الأرجنتين','is_active'=>1],                  
            ['name' => 'أرمينيا','is_active'=>1],                   
            ['name' => 'أروبا','is_active'=>1],                     
            ['name' => 'صعود','is_active'=>1],                      
            ['name' => 'أستراليا','is_active'=>1],                  
            ['name' => 'الأقاليم الخارجية الأسترالية','is_active'=>1],
            ['name' => 'النمسا','is_active'=>1],                    
            ['name' => 'أذربيجان','is_active'=>1],                  
            ['name' => 'الباهاما','is_active'=>1],                  
            ['name' => 'البحرين','is_active'=>1],                   
            ['name' => 'بنغلاديش','is_active'=>1],                   
            ['name' => 'بربادوس','is_active'=>1],                   
            ['name' => 'باربودا','is_active'=>1],                   
            ['name' => 'روسيا البيضاء','is_active'=>1],             
            ['name' => 'بلجيكا','is_active'=>1],                    
            ['name' => 'بليز','is_active'=>1],                      
            ['name' => 'بنين','is_active'=>1],                      
            ['name' => 'برمودا','is_active'=>1],                    
            ['name' => 'بوتان','is_active'=>1],                     
            ['name' => 'بوليفيا','is_active'=>1],                   
            ['name' => 'البوسنة والهرسك','is_active'=>1],           
            ['name' => 'بوتسوانا','is_active'=>1],                  
            ['name' => 'البرازيل','is_active'=>1],                  
            ['name' => 'إقليم المحيط البريطاني الهندي246','is_active'=>1],
            ['name' => 'جزر فيرجن البريطانية','is_active'=>1],      
            ['name' => 'بروناي','is_active'=>1],                    
            ['name' => 'بلغاريا','is_active'=>1],                   
            ['name' => 'بوركينا فاسو','is_active'=>1],              
            ['name' => 'بوروندي','is_active'=>1],                   
            ['name' => 'كمبوديا','is_active'=>1],                   
            ['name' => 'الكاميرون','is_active'=>1],                 
            ['name' => 'كندا','is_active'=>1],                      
            ['name' => 'الرأس الأخضر','is_active'=>1],               
            ['name' => 'الكاريبي هولندا','is_active'=>1],           
            ['name' => 'جزر كايمان','is_active'=>1],                
            ['name' => 'جمهورية افريقيا الوسطى','is_active'=>1],    
            ['name' => 'تشاد','is_active'=>1],                      
            ['name' => 'تشيلي','is_active'=>1],                     
            ['name' => 'الصين','is_active'=>1],                     
            ['name' => 'جزيرة الكريسماس','is_active'=>1],           
            ['name' => 'جزر كوكوس (كيلينغ)','is_active'=>1],        
            ['name' => 'كولومبيا','is_active'=>1],                  
            ['name' => 'جزر القمر','is_active'=>1],                 
            ['name' => 'الكونغو - برازافيل','is_active'=>1],        
            ['name' => 'الكونغو - كينشاسا','is_active'=>1],         
            ['name' => 'جزر كوك','is_active'=>1],                   
            ['name' => 'كوستا ريكا','is_active'=>1],                
            ['name' => 'كوت ديفوار','is_active'=>1],                
            ['name' => 'كرواتيا','is_active'=>1],                   
            ['name' => 'كوبا','is_active'=>1],                      
            ['name' => 'كوراساو','is_active'=>1],                   
            ['name' => 'قبرص','is_active'=>1],                      
            ['name' => 'جمهورية التشيك','is_active'=>1],            
            ['name' => 'الدنمارك','is_active'=>1],                  
            ['name' => 'دييغو غارسيا','is_active'=>1],              
            ['name' => 'جيبوتي','is_active'=>1],                    
            ['name' => 'دومينيكا','is_active'=>1],                  
            ['name' => 'جمهورية الدومنيكان','is_active'=>1],       
            ['name' => 'الإكوادور','is_active'=>1],                  
            ['name' => 'مصر','is_active'=>1],                       
            ['name' => 'السلفادور','is_active'=>1],                 
            ['name' => 'غينيا الإستوائية','is_active'=>1],           
            ['name' => 'إريتريا','is_active'=>1],                   
            ['name' => 'استونيا','is_active'=>1],                   
            ['name' => 'أثيوبيا','is_active'=>1],                   
            ['name' => 'جزر فوكلاند','is_active'=>1],                
            ['name' => 'جزر فاروس','is_active'=>1],                 
            ['name' => 'فيجي','is_active'=>1],                      
            ['name' => 'فنلندا','is_active'=>1],                    
            ['name' => 'فرنسا','is_active'=>1],                     
            ['name' => 'غيانا الفرنسية','is_active'=>1],            
            ['name' => 'بولينيزيا الفرنسية','is_active'=>1],        
            ['name' => 'الغابون','is_active'=>1],                   
            ['name' => 'غامبيا','is_active'=>1],                    
            ['name' => 'جورجيا','is_active'=>1],                    
            ['name' => 'ألمانيا','is_active'=>1],                   
            ['name' => 'غانا','is_active'=>1],                      
            ['name' => 'جبل طارق','is_active'=>1],                  
            ['name' => 'اليونان','is_active'=>1],                   
            ['name' => 'الأرض الخضراء','is_active'=>1],              
            ['name' => 'غرينادا','is_active'=>1],                   
            ['name' => 'جوادلوب','is_active'=>1],                   
            ['name' => 'غوام','is_active'=>1],                      
            ['name' => 'غواتيمالا','is_active'=>1],                  
            ['name' => 'غيرنسي','is_active'=>1],                    
            ['name' => 'غينيا','is_active'=>1],                     
            ['name' => 'غينيا بيساو','is_active'=>1],               
            ['name' => 'غيانا','is_active'=>1],                     
            ['name' => 'هايتي','is_active'=>1],                     
            ['name' => 'هندوراس','is_active'=>1],                   
            ['name' => 'هونج كونج SAR الصين','is_active'=>1],       
            ['name' => 'هنغاريا','is_active'=>1],                   
            ['name' => 'أيسلندا','is_active'=>1],                   
            ['name' => 'الهند','is_active'=>1],                     
            ['name' => 'إندونيسيا','is_active'=>1],                 
            ['name' => 'إيران','is_active'=>1],                     
            ['name' => 'العراق','is_active'=>1],                    
            ['name' => 'أيرلندا','is_active'=>1],                   
            ['name' => 'الكيان الصهيوني','is_active'=>1],           
            ['name' => 'إيطاليا','is_active'=>1],                   
            ['name' => 'جامايكا','is_active'=>1],                   
            ['name' => 'اليابان','is_active'=>1],                   
            ['name' => 'جيرسي','is_active'=>1],                     
            ['name' => 'الأردن','is_active'=>1],                     
            ['name' => 'كازاخستان','is_active'=>1],                 
            ['name' => 'كازاخستان','is_active'=>1],                 
            ['name' => 'كينيا','is_active'=>1],                     
            ['name' => 'كيريباس','is_active'=>1],                   
            ['name' => 'الكويت','is_active'=>1],                    
            ['name' => 'قرغيزستان','is_active'=>1],                 
            ['name' => 'لاوس','is_active'=>1],                       
            ['name' => 'لاتفيا','is_active'=>1],                     
            ['name' => 'لبنان','is_active'=>1],                     
            ['name' => 'ليسوتو','is_active'=>1],                    
            ['name' => 'ليبيريا','is_active'=>1],                   
            ['name' => 'ليبيا','is_active'=>1],                     
            ['name' => 'ليختنشتاين','is_active'=>1],                
            ['name' => 'ليتوانيا','is_active'=>1],                  
            ['name' => 'لوكسمبورغ','is_active'=>1],                 
            ['name' => 'ماكاو SAR الصين','is_active'=>1],           
            ['name' => 'مقدونيا','is_active'=>1],                   
            ['name' => 'مدغشقر','is_active'=>1],                    
            ['name' => 'مالاوي','is_active'=>1],                     
            ['name' => 'ماليزيا','is_active'=>1],                   
            ['name' => 'جزر المالديف','is_active'=>1],              
            ['name' => 'مالي','is_active'=>1],                      
            ['name' => 'مالطا','is_active'=>1],                     
            ['name' => 'جزر مارشال','is_active'=>1],                
            ['name' => 'مارتينيك','is_active'=>1],                  
            ['name' => 'موريتانيا','is_active'=>1],                 
            ['name' => 'موريشيوس','is_active'=>1],                  
            ['name' => 'مايوت','is_active'=>1],                     
            ['name' => 'المكسيك','is_active'=>1],                   
            ['name' => 'ميكرونيزيا','is_active'=>1],                
            ['name' => 'مولدوفا','is_active'=>1],                   
            ['name' => 'موناكو','is_active'=>1],                    
            ['name' => 'منغوليا','is_active'=>1],                   
            ['name' => 'الجبل الأسود','is_active'=>1],               
            ['name' => 'مونتسيرات','is_active'=>1],                 
            ['name' => 'المغرب','is_active'=>1],                    
            ['name' => 'موزمبيق','is_active'=>1],                   
            ['name' => 'ميانمار (بورما)','is_active'=>1],           
            ['name' => 'ناميبيا','is_active'=>1],                   
            ['name' => 'ناورو','is_active'=>1],                     
            ['name' => 'نيبال','is_active'=>1],                     
            ['name' => 'هولندا','is_active'=>1],                    
            ['name' => 'كاليدونيا الجديدة','is_active'=>1],         
            ['name' => 'نيوزيلاندا','is_active'=>1],                 
            ['name' => 'نيكاراغوا','is_active'=>1],                 
            ['name' => 'النيجر','is_active'=>1],                    
            ['name' => 'نيجيريا','is_active'=>1],                   
            ['name' => 'نيوي','is_active'=>1],                      
            ['name' => 'جزيرة نورفولك','is_active'=>1],             
            ['name' => 'كوريا الشماليه','is_active'=>1],            
            ['name' => 'جزر مريانا الشمالية','is_active'=>1],       
            ['name' => 'النرويج','is_active'=>1],                   
            ['name' => 'سلطنة عمان','is_active'=>1],                
            ['name' => 'باكستان','is_active'=>1],                   
            ['name' => 'بالاو','is_active'=>1],                      
            ['name' => 'فلسطين','is_active'=>1],                    
            ['name' => 'بناما','is_active'=>1],                     
            ['name' => 'بابوا غينيا الجديدة','is_active'=>1],       
            ['name' => 'باراغواي','is_active'=>1],                  
            ['name' => 'بيرو','is_active'=>1],                      
            ['name' => 'الفلبين','is_active'=>1],                   
            ['name' => 'جزر بيتكيرن','is_active'=>1],               
            ['name' => 'بولندا','is_active'=>1],                    
            ['name' => 'البرتغال','is_active'=>1],                  
            ['name' => 'بورتوريكو','is_active'=>1],                 
            ['name' => 'بورتوريكو','is_active'=>1],                 
            ['name' => 'دولة قطر','is_active'=>1],                  
            ['name' => 'جمع شمل','is_active'=>1],                   
            ['name' => 'رومانيا','is_active'=>1],                   
            ['name' => 'روسيا','is_active'=>1],                     
            ['name' => 'رواندا','is_active'=>1],                    
            ['name' => 'ساموا','is_active'=>1],                     
            ['name' => 'سان مارينو','is_active'=>1],                
            ['name' => 'ساو تومي برينسيبي','is_active'=>1],         
            ['name' => 'المملكة العربية السعودية','is_active'=>1],  
            ['name' => 'السنغال','is_active'=>1],                   
            ['name' => 'صربيا','is_active'=>1],                     
            ['name' => 'سيشيل','is_active'=>1],                     
            ['name' => 'سيرا ليون','is_active'=>1],                 
            ['name' => 'سنغافورة','is_active'=>1],                  
            ['name' => 'سينت أوستاتيوس','is_active'=>1],            
            ['name' => 'سينت مارتن','is_active'=>1],                
            ['name' => 'سلوفاكيا','is_active'=>1],                  
            ['name' => 'سلوفينيا','is_active'=>1],                  
            ['name' => 'جزر سليمان','is_active'=>1],                
            ['name' => 'الصومال','is_active'=>1],                   
            ['name' => 'جنوب أفريقيا','is_active'=>1],              
            ['name' => 'جورجيا الجنوبية جزر ساندويتش','is_active'=>1],
            ['name' => 'كوريا الجنوبية','is_active'=>1],            
            ['name' => 'أوسيتيا الجنوبية','is_active'=>1],          
            ['name' => 'جنوب السودان','is_active'=>1],              
            ['name' => 'إسبانيا','is_active'=>1],                   
            ['name' => 'سيريلانكا','is_active'=>1],                  
            ['name' => 'سانت بارتيليمي','is_active'=>1],            
            ['name' => 'سانت هيلانة','is_active'=>1],                
            ['name' => 'سانت كيتس نيفيس','is_active'=>1],           
            ['name' => 'شارع لوسيا','is_active'=>1],                
            ['name' => 'سانت مارتن (فرنسا)','is_active'=>1],        
            ['name' => 'سانت بيير وميكلون','is_active'=>1],         
            ['name' => 'سانت فنسنت وجزر غرينادين','is_active'=>1],  
            ['name' => 'السودان','is_active'=>1],                   
            ['name' => 'سورينام','is_active'=>1],                   
            ['name' => 'سفالبارد','is_active'=>1],                  
            ['name' => 'سفالبارد جان ماين','is_active'=>1],         
            ['name' => 'سوازيلاند','is_active'=>1],                  
            ['name' => 'السويد','is_active'=>1],                    
            ['name' => 'سويسرا','is_active'=>1],                    
            ['name' => 'سوريا','is_active'=>1],                     
            ['name' => 'تايوان','is_active'=>1],                    
            ['name' => 'طاجيكستان','is_active'=>1],                 
            ['name' => 'تنزانيا','is_active'=>1],                   
            ['name' => 'تايلاند','is_active'=>1],                    
            ['name' => 'تيمور الشرقية','is_active'=>1],             
            ['name' => 'توجو','is_active'=>1],                      
            ['name' => 'توكيلاو','is_active'=>1],                    
            ['name' => 'تونغا','is_active'=>1],                     
            ['name' => 'ترينيداد وتوباجو','is_active'=>1],          
            ['name' => 'تونس','is_active'=>1],                      
            ['name' => 'ديك رومي','is_active'=>1],                  
            ['name' => 'تركمانستان','is_active'=>1],                
            ['name' => 'جزر تركس كايكوس','is_active'=>1],           
            ['name' => 'توفالو','is_active'=>1],                    
            ['name' => 'جزر فيرجن الأمريكية','is_active'=>1],        
            ['name' => 'أوغندا','is_active'=>1],                    
            ['name' => 'أوكرانيا','is_active'=>1],                  
            ['name' => 'الإمارات العربية المتحدة','is_active'=>1],   
            ['name' => 'المملكة المتحدة','is_active'=>1],           
            ['name' => 'الولايات المتحدة الأمريكية','is_active'=>1],  
            ['name' => 'أوروغواي','is_active'=>1],                  
            ['name' => 'أوزبكستان','is_active'=>1],                 
            ['name' => 'فانواتو','is_active'=>1],                   
            ['name' => 'مدينة الفاتيكان','is_active'=>1],           
            ['name' => 'مدينة الفاتيكان','is_active'=>1],           
            ['name' => 'فنزويلا','is_active'=>1],                    
            ['name' => 'فيتنام','is_active'=>1],                    
            ['name' => 'واليس فوتونا','is_active'=>1],              
            ['name' => 'اليمن','is_active'=>1],                     
            ['name' => 'زامبيا','is_active'=>1],                    
            ['name' => 'زنجبار','is_active'=>1],                    
        ]);

        
    }
}