<!-- Exemplos de uso: O padrão Factory Method é amplamente utilizado no código PHP. É muito útil quando você precisa fornecer um alto nível de flexibilidade para seu código.

Identificação: Os métodos fábrica podem ser reconhecidos por métodos de criação, que criam objetos de classes concretas, mas os retornam como objetos de tipo ou interface abstrata. -->

<?php

namespace RefactoringGuru\FactoryMethod\Conceptual;

/**
 * A classe Creator declara o método de fábrica que deve retornar um
 * objeto de uma classe Product. As subclasses do Criador geralmente fornecem a
 * implementação deste método. 
 */
abstract class Creator
{
    /**
     * Observe que o Criador também pode fornecer alguma implementação padrão do
     * método de fábrica. 
     */
    abstract public function factoryMethod(): Product;

    /**
     * Observe também que, apesar do nome, a principal responsabilidade do Criador é
     * não criando produtos. Normalmente, ele contém alguma lógica de negócios principal que
     * depende de objetos Product, retornados pelo método de fábrica. As subclasses podem
     * alterar indiretamente essa lógica de negócios substituindo o método de fábrica
     * e devolver um tipo de produto diferente dele. 
     */
    public function someOperation(): string
    {
        // Chame o método de fábrica para criar um objeto Product. 
        $product = $this->factoryMethod();
        // Agora, use o produto. 
        $result = "Creator: The same creator's code has just worked with " .
            $product->operation();

        return $result;
    }
}

/**
 * Os criadores de concreto substituem o método de fábrica para alterar o
 * tipo de produto resultante. 
 */
class ConcreteCreator1 extends Creator
{
    /**
     * Observe que a assinatura do método ainda usa o produto abstrato
     * tipo, mesmo que o produto de concreto seja realmente devolvido do
     * método. Desta forma, o Criador pode ficar independente do produto concreto
     * Aulas. 
     */
    public function factoryMethod(): Product
    {
        return new ConcreteProduct1();
    }
}

class ConcreteCreator2 extends Creator
{
    public function factoryMethod(): Product
    {
        return new ConcreteProduct2();
    }
}

/**
 * A interface Produto declara as operações que todos os produtos concretos devem
 * implemento. 
 */
interface Product
{
    public function operation(): string;
}

/**
 * Os Produtos Concretos fornecem várias implementações da interface do Produto. 
 */
class ConcreteProduct1 implements Product
{
    public function operation(): string
    {
        return "{Result of the ConcreteProduct1}";
    }
}

class ConcreteProduct2 implements Product
{
    public function operation(): string
    {
        return "{Result of the ConcreteProduct2}";
    }
}

/**
 * O código cliente funciona com uma instância de um criador concreto, embora por meio de
 * sua interface básica. Enquanto o cliente continuar trabalhando com o criador via
 * a interface base, você pode passar a subclasse de qualquer criador. 
 */
function clientCode(Creator $creator)
{
    // ...
    echo "Client: I'm not aware of the creator's class, but it still works.\n"
        . $creator->someOperation();
    // ...
}

/**
 * O Aplicativo escolhe o tipo de criador dependendo da configuração ou
 * meio Ambiente. 
 */
echo "App: Launched with the ConcreteCreator1.\n";
clientCode(new ConcreteCreator1());
echo "\n\n";

echo "App: Launched with the ConcreteCreator2.\n";
clientCode(new ConcreteCreator2());
