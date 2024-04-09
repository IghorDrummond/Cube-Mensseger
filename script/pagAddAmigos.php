	<h6 class="text-white">Adicione Amigos!</h6>
							<form class="border border-white w-75 h-75 p-1 d-flex flex-column" action="script/buscaAmigo.php" method="POST">
								<pre class="w-100 h-100 bg-transparent">
									<ul class="list-group">
									<?php
										$Lista = isset($_SESSION['Amigos']) ? $_SESSION['Amigos'] : [];
										unset($_SESSION['Amigos']);

										if(isset($Lista[0][1])){
									?>	
									<span id="lista_amigos" class="badge badge-pill badge-success sticky-top">Encontrados: <?php echo($_SESSION['Busca']); ?></span>
									<?php			
											unset($_SESSION['Busca']);															
											for($nCont = 0; $nCont <= count($Lista) -1; $nCont++){
									?>
										<li class="list-group-item bg-info text-center w-100 d-flex justify-content-between align-items-center" id="<? echo ($Lista[$nCont][1]); ?>">
											<img src="<? echo ($Lista[$nCont][2]); ?>" class="border border-dark" align="left">
											<h6 class="d-inline"><? echo ($Lista[$nCont][1]); ?></h6>
											<button class="btn btn-success d-flex justify-content-center align-items-center p-3 border border-dark" onclick="adicionar('<?php echo($Lista[$nCont][1]) ?>')">
												<i class="fa-solid fa-user-plus fa-lg" style="color: black;"></i>
											</button>
										</li>
									<?php	
											}										
										}
									?>
									</ul>
								</pre>
								<div class="input-group align-self-end">
									<input class="form-control" type="text" name="Amigo" placeholder="Pesquise Seus Amigos(as) Aqui..." required>
									<div class="input-group-append">
										<button class="btn btn-primary" type="submit">Pesquisar</button>
									</div>
								</div>
							</form>