GNU nano 5.4                                                    2024_11_17_222008_create_cache_table.php                                                              
<?php 
use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema; 
                                                                                                                                                                        
class CreateCacheTable extends Migration{
    /** * Run the migrations. */ 
        public function up(): void 
        { 
                Schema::create('cache', function (Blueprint $table) { 
                        $table->string('key')->primary(); 
                        $table->text('value'); 
                        $table->integer('expiration');
                });                                                                                                                                                     
        }                                                                                                                                                               
                                                                                                                                                                        
    /** * Reverse the migrations. */ 
        public function down(): void { 
                Schema::dropIfExists('cache');
        }                                                                                                                                                               
}                  
