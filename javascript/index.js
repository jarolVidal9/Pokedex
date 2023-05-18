const url = 'https://pokeapi.co/api/v2/pokemon/?limit=100';
		fetch(url)
			.then(response => response.json())
			.then(data => {
				const pokemonList = document.getElementById('lista');
				data.results.forEach(pokemon => {
					const pokemonUrl = pokemon.url;
					fetch(pokemonUrl)
						.then(response => response.json())
						.then(data => {
							const nombre = data.name;
							const imageUrl = data.sprites.front_default;
							const Poketipo = 'data.type';

                            //Elemento que va a tener el titulo
							const h = document.createElement('h5');
							h.textContent = nombre;
							//Elemento que contiene la imagen
							const image= document.createElement('img');
							image.classList.add('img-fluid','imgcolor','w-100');
                            image.src = imageUrl;

							//contenedor
							const contenedor = document.createElement('div');
							contenedor.classList.add('col-6','col-md-2','pokecard');
						
							//SubContenedor
							const subcontenedor=document.createElement('div')
							subcontenedor.classList.add('subcontenedor','card')
							
							subcontenedor.appendChild(image);
							subcontenedor.appendChild(h);

							contenedor.appendChild(subcontenedor)

							contenedor.addEventListener('click', () => {
								cargarMasDatos(pokemonUrl);
							  });
					
							pokemonList.appendChild(contenedor);
						})
						.catch(error => console.error(error));
				});
			})
			.catch(error => console.error(error));
			function cargarMasDatos(pokemonData) {
				fetch(pokemonData)
				  .then(response => response.json())
				  .then(data => {
					const modalTitle = document.getElementById('modalTitle');
					const modalBody = document.getElementById('modalBody');

					modalTitle.textContent = '';
					modalBody.innerHTML = '';

					modalTitle.textContent = data.name;

					const image = document.createElement('img');
					image.src = data.sprites.front_default;
					image.classList.add('img-fluid','w-100','Pokeimagen');

					const containerImage = document.createElement('div');
					containerImage.classList.add('col-6');
					
					containerImage.appendChild(image);
					const container= document.createElement('div');
					container.classList.add('row')

					const information =document.createElement('div');
					information.classList.add('col-6');

					const Estatura = document.createElement('p');
					Estatura.textContent = `Estatura: ${data.height}`;

					const Peso = document.createElement('p');
					Peso.textContent = `Peso: ${data.weight}`;

					const abilities = data.abilities.map(ability => ability.ability.name).join(', ');
					const abilitiesParagraph = document.createElement('p');

					const types = data.types.map(type => type.type.name).join(', ');
					const typesParagraph = document.createElement('p');
					typesParagraph.textContent = `Tipo: ${types}`;

					abilitiesParagraph.textContent = `Habilidades: ${abilities}`;
					
					information.appendChild(Estatura);
					information.appendChild(Peso);
					information.appendChild(abilitiesParagraph);
					information.appendChild(typesParagraph);
					container.appendChild(containerImage);
					container.appendChild(information);

					modalBody.appendChild(container)
			  
					$('#myModal').modal('show');
				  })
				  .catch(error => console.error(error));
			  }