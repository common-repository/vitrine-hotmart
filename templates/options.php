<div class="wrap">
<div class="icon32"><img src='<?php echo plugins_url('/images/icon-32.png', dirname(__FILE__))?>' /></div>
        
<h2>Configuração <?php echo self::PLUGIN_NAME?>:</h2>
    
  		<table width="100%"><tr>
        <td style="vertical-align:top"><form action="" method="post">
          
          <div class="metabox-holder">         
		<div class="postbox" >
        
        	<h3>Adicionar Nova Vitrine</h3>
        
        	<div class="inside">
                
                            
            	<p>
                <label>Nome da Vitrine</label> <input type="text" value="<?php echo $options["nome"]?>" name="nome" /> <small>Digite um nome para identificação da Vitrine</small>
                </p>
                                
            	<p>
                <label>Quantidade de Produtos por Linha</label> 
                <select name="produtos_por_linha" >
                	<?php
					for($i=1;$i<21;$i++){
                    	echo '<option value="'.$i.'" >'.$i.'</option>';
					}
                	?>
				</select>
                </p>
 
             	<p>
                <label>Ordem de Exibição dos Produtos</label> 
                <select name="ordem_produtos" >
                	<?php
					for($i=0;$i<4;$i++){
                    	echo '<option value="'.$i.'" >'.$ordem[$i][1] .'</option>';
					}
                	?>
				</select>
                </p>
                
                 <p>
                <input type="submit" name="submit" value="Adicionar" class="myButton" />
				</p>
                               
                			</div>
		</div>
        </div>
 		</form>
 		<form action="" method="post">
 		<div class="metabox-holder">
 		<div class="postbox">
        
        	<h3>Vitrines já Criadas (<span style="color:red">Ao excluir uma Vitrine, todos os Produtos dela serão excluídos</span>)</h3>
        
        	<div class="inside">
            	<p>
                <table id="listagem-vitrines" class="display" cellspacing="0" width="100%">
                <thead>
				<tr>
				<th>
				Nome da Vitrine
				</th> 
				<th>
				Shortcode da Vitrine
				</th>
                                
				<th>
				Produtos por Linha
				</th>
				<th>
				Ordenação
				</th>
                <th>
                Ações
                </th>               
				</tr>  
                </thead>         
                <tbody>                         
                <?php
					
					foreach($vitrines as $vitrine){
						echo "<tr>";
						echo "<td class='center'>";
						echo $vitrine["nome"];
						echo "</td>";						
						echo "<td class='center'>";
						echo '<input type="text" readonly="readonly" value="[vitrine-hot id='. $vitrine["id"]. ']" onclick="this.select();" />';
						echo "</td>";
						echo "<td class='center'>";
						echo $vitrine["produtos_por_linha"];
						echo "</td>";
						echo "<td class='center'>";
						echo $ordem[$vitrine["ordem"]][1];
						echo "</td>";
						echo "<td class='center'>";
						echo "<a href='".$admin_url."&id=".$vitrine["id"]."' class='button-secondary'>Editar</a> ";	
						echo "<a href='".$admin_url."&iddel=".$vitrine["id"]."' class='button-secondary'>Excluir</a>";
						echo "</td>";
						echo "</tr>";
					}
				?>
                </tbody>
                <tfoot> 
				<tr>
				<th>
				ID
				</th>
				<th>
				Nome da Vitrine
				</th> 
				<th>
				Produtos por Linha
				</th>
				<th>
				Ordenação
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

	$url_banner = 'http://andersonmak.com/admiyn?hotvitrine-'. $lingua;	
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