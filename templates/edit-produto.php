<?php
if(isset($_POST["alterar"])){
	
	if(empty($_POST['nome_produto']) || empty($_POST['descritivo']) || empty($_POST['url_compra']) || empty($_POST['url_imagem']) ){

	echo '<div id="message" class="error">';
	echo '<p><strong>'. 'Há campos não preenchidos!<br>Preencha todos os campos e Tente novamente!' . '</strong></p>';
	echo '</div>';					
	
	}else{

		
		$wpdb->query( $wpdb->prepare( 
			"
				update $table_name_produtos
				set nome = %s, descritivo = %s, preco = %s, url_compra = %s, url_imagem = %s
				where id = %d
			", 
			$_POST['nome_produto'], 
			$_POST['descritivo'], 
			$_POST['preco'],
			$_POST['url_compra'],
			$_POST['url_imagem'], 
			$_POST['pid'] 
		) );		
		
		//$wpdb->show_errors();	
		//$wpdb->print_error();	

		echo '<div id="message" class="updated">';
		echo '<p><strong>'. 'Produto Atualizado com sucesso!' . '</strong></p>';
		echo '</div>';	
					
	}

}


$produto = $wpdb->get_row( $wpdb->prepare( 
	"
		SELECT * FROM $table_name_produtos
		where id = %d
	", 
	$_REQUEST["pid"] 
), ARRAY_A );
?>
<div class="wrap">
<div class="icon32"><img src='<?php echo plugins_url('/images/icon-32.png', dirname(__FILE__))?>' /></div>
        
<h2>Configuração <?php echo self::PLUGIN_NAME?>:</h2>
    
  		<table width="100%"><tr>
        <td style="vertical-align:top">
        
        
 		<form action="" method="post">
        
        <div class="metabox-holder">         
		<div class="postbox" >
        
        	<h3>Editar Produto</h3>
        
        	<div class="inside">
                
                            
            	<p>
                <label>Nome do Produto</label> <input type="text" value="<?php echo $produto["nome"];?>" name="nome_produto" /> <small>Digite um nome para identificação da Vitrine</small>
                </p>
                                
            	<p>
                <label>Breve Descritivo do Produto</label> <input type="text" value="<?php echo $produto["descritivo"];?>" name="descritivo" class="large-text" />
                </p>

            	<p>
                <label>Preço</label> <input type="text" value="<?php echo $produto["preco"];?>" name="preco"  />
                </p>
                
            	<p>
                <label>Url para Compra</label> <input type="text" value="<?php echo $produto["url_compra"];?>" name="url_compra" class="regular-text"  /> <small>Endereço para onde o usuário será redirecionado</small>
                </p>
                
            	<p>
                <label>Url da Imagem</label> <input type="text" value="<?php echo $produto["url_imagem"];?>" name="url_imagem" class="regular-text"  /> <small>A Imagem deve ter 250x250 pixels.</small>
                </p>
                
               <p>
               	<input type="hidden" name="id" value="<?php echo $_REQUEST["id"]?>">
                <input type="hidden" name="pid" value="<?php echo $_REQUEST["pid"]?>">
                <input type="submit" name="alterar" value="Salvar Alterações" class="myButton" /> <a href="<?php echo $admin_url . '&id='. $_REQUEST["id"];?>" class="button-secondary" >Voltar para a Vitrine</a>
				</p>
                               
                			</div>
		</div>
        </div>
        
 		</form>
          
   		</td>

       </tr>

       </table>





<hr />
<p>
<center>
  <?php 
	$lingua = get_bloginfo("language");

	$url_banner = 'http://andersonmak.com/admiyn?hotlogin-'. $lingua;	
	$imagem_banner = 'banner.jpg';
	

	$imagem_banner = $anderson_makiyama[self::PLUGIN_ID]->plugin_url .'images/' . $imagem_banner;
?>
                 <a href="<?php echo $url_banner?>"><img src="<?php echo $imagem_banner;?>" /></a>  
</center>  
</p>

</div>
<script>

jQuery(document).ready(function($) {
     $('#listagem-vitrines').dataTable();
});
</script>