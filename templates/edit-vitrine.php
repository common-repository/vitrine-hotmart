<div class="wrap">
<div class="icon32"><img src='<?php echo plugins_url('/images/icon-32.png', dirname(__FILE__))?>' /></div>
        
<h2>Configuração <?php echo self::PLUGIN_NAME?>:</h2>
    
  		<table width="100%"><tr>
        <td style="vertical-align:top">
 
 		<form action="" method="post">
        
        <div class="metabox-holder">         
		<div class="postbox" >
        
        	<h3>Atualizar a Vitrine</h3>
        
        	<div class="inside">
                
                            
            	<p>
                <label>Nome da Vitrine</label> <input type="text" value="<?php echo $vitrine["nome"]?>" name="nome" /> <small>Digite um nome para identificação da Vitrine</small>
                </p>
                                
            	<p>
                <label>Quantidade de Produtos por Linha</label> 
                <select name="produtos_por_linha" >
                	<?php
					for($i=1;$i<21;$i++){
                    	echo '<option value="'.$i.'" '. selected($i,$vitrine["produtos_por_linha"])  .' >'.$i.'</option>';
					}
                	?>
				</select>
                </p>

             	<p>
                <label>Ordem de Exibição dos Produtos</label> 
                <select name="ordem_produtos" >
                	<?php
					for($i=0;$i<4;$i++){
                    	echo '<option value="'.$i.'" '. selected($i,$vitrine["ordem"]) .' >'.$ordem[$i][1] .'</option>';
					}
                	?>
				</select>
                </p>
                
                <p>
                Shortcode da Vitrine: <input type="text" readonly="readonly" value="[vitrine-hot id=<?php echo $_REQUEST["id"]?>]" onclick="this.select();" />
                </p>
                
                <p>
                <input type="hidden" name="id" value="<?php echo $_REQUEST["id"]?>">
                <input type="submit" name="atualizar" value="Atualizar Vitrine" class="myButton" />  <a href="<?php echo $admin_url;?>" class="button-secondary" >Voltar para Listagem de Vitrines</a>
				</p>
                               
                			</div>
		</div>
        </div>
 		</form>
        
 		<form action="" method="post">
        
        <div class="metabox-holder">         
		<div class="postbox" >
        
        	<h3>Adicionar Novo Produto</h3>
        
        	<div class="inside">
                
                            
            	<p>
                <label>Nome do Produto</label> <input type="text" value="<?php ?>" name="nome_produto" /> <small>Digite um nome para identificação da Vitrine</small>
                </p>
                                
            	<p>
                <label>Breve Descritivo do Produto</label> <input type="text" value="<?php ?>" name="descritivo" class="large-text" />
                </p>

            	<p>
                <label>Preço</label> <input type="text" value="<?php ?>" name="preco"  /> <small>Deixe em Branco para Não mostrar Preço</small>
                </p>
                
            	<p>
                <label>Url para Compra</label> <input type="text" value="<?php ?>" name="url_compra" class="regular-text"  /> <small>Endereço para onde o usuário será redirecionado</small>
                </p>
                
            	<p>
                <label>Url da Imagem</label> <input type="text" value="<?php ?>" name="url_imagem" class="regular-text"  />
                </p>
                
               <p>
               	<input type="hidden" name="id" value="<?php echo $_REQUEST["id"]?>">
                <input type="submit" name="adicionar" value="Adicionar Novo Produto" class="myButton" />
				</p>
                               
                			</div>
		</div>
        </div>
        
 		</form>
                
 		<form action="" method="post">
 		<div class="metabox-holder">
 		<div class="postbox">
        
        	<h3>Produtos já Inseridos na Vitrine</h3>
        
        	<div class="inside">
            	<p>
                <table id="listagem-vitrines" class="display" cellspacing="0" width="100%">
                <thead>
				<tr>
				<th>
				Nome do Produto
				</th> 
				<th>
				Imagem
				</th>          
				<th>
				Preço
				</th>
				<th>
				Descritivo
				</th>
                <th>
				Link de Compra
				</th>
                <th>
                </th>               
				</tr>  
                </thead>         
                <tbody>                         
                <?php
					
					foreach($produtos as $produto){
						
						$imagem = empty($produto["url_imagem"])?"":"<img src='". $produto["url_imagem"] ."' width='100'>";
						$link = empty($produto["url_compra"])?"":"<a href='". $produto["url_compra"] ."' target='_blank'>Link</a>";

						echo "<tr>";
						echo "<td class='center'>";
						echo $produto["nome"];
						echo "</td>";						
						echo "<td class='center'>";
						echo $imagem;
						echo "</td>";
						echo "<td class='center'>";
						echo $produto["preco"];
						echo "</td>";
						echo "<td class='center'>";
						echo $produto["descritivo"];
						echo "</td>";
						echo "<td class='center'>";
						echo $link;
						echo "</td>";
						echo "<td class='center'>";
						echo "<a href='".$admin_url."&id=".$_REQUEST["id"]."&pid=". $produto["id"] ."' class='button-secondary'>Editar</a><br>";
						echo "<a href='".$admin_url."&id=".$_REQUEST["id"]."&piddel=". $produto["id"] ."' class='button-secondary'>Excluir</a>";	
						echo "</td>";
						echo "</tr>";
					}
				?>
                </tbody>
                <tfoot> 
				<tr>
				<th>
				Nome do Produto
				</th> 
				<th>
				Imagem
				</th>          
				<th>
				Preço
				</th>
				<th>
				Descritivo
				</th>
                <th>
				Link de Compra
				</th>
                <th>
                </th>               
				</tr>  
                </tfoot>                 
                </table>
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