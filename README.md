APS 3 – Laravel

Estruturação básica de models, views e controllers usando rotas

Nesta primeira etapa, o objetivo é estruturar uma aplicação Laravel simples, focando na criação
de controllers, views e rotas do tipo GET. A ideia é que você se familiarize com a separação entre
lógica de controle e apresentação, utilizando o padrão MVC (Model-View-Controller).

- Crie no mínimo 2 controllers, cada um responsável por uma funcionalidade diferente
(ex: ProdutoController e CategoriaController);
- Crie no mínimo 2 views, associadas a cada controller, utilizando Blade;
- Configure rotas GET no arquivo web.php, apontando para os métodos index() de
cada controller, que devem retornar as respectivas views.

Com a estrutura inicial pronta, agora você irá expandir sua aplicação adicionando interação com
o banco de dados por meio de formulários. Essa parte envolve a criação de migrations e models
para armazenar informações, além da implementação da lógica para exibir os dados cadastrados
e permitir o envio de novos registros. A ideia é continuar usando as views criadas anteriormente,
tornando-as mais completas ao incluir um formulário de cadastro e uma listagem dos itens já
salvos no banco de dados. Toda a lógica de salvamento e exibição de dados deve ser incluída
nas controllers criadas anteriormente, respeitando o princípio de reaproveitamento de código
e organização.

- Criar 2 models com suas migrations correspondentes (ex: Produto e Categoria);
- Utilizar as mesmas views criadas anteriormente para:
    - Exibir os registros já salvos no banco (em forma de lista);
    - Exibir um formulário de cadastro para novos registros;
- Implementar a lógica de listagem e salvamento nas mesmas 2 controllers, adicionando
um método store() responsável por tratar requisições POST;
- Configurar as seguintes rotas:
    - GET /produtos → exibe formulário e lista de produtos
       (ProdutoController@index);
    - POST /produtos → processa o formulário e salva no banco
       (ProdutoController@store);
    - GET /categorias → exibe formulário e lista de categorias
       (CategoriaController@index);
    - POST /categorias → processa o formulário e salva no banco
       (CategoriaController@store);

Lembre-se de utilizar validação básica dos dados recebidos e de exibir mensagens de
sucesso ou erro, caso possível (por exemplo:
https://laravel.com/docs/12.x/validation#rule-required).