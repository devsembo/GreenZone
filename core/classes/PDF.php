<?php 
namespace core\classes;
use Mpdf\Mpdf;

class PDF 
{
    private $pdf;
    private $html;

    private $x; // left
    private $y; // top
    private $largura;   // width
    private $altura;    // hight
    private $alinhamento;   // text-align

    private $cor;   // fore-color
    private $fundo; // background-color

    private $letra_familia; // font-family
    private $letra_tamanho; // font-size
    private $letra_tipo;    // font-weight

    private $mostrar_areas; // mostra ou esconde um contorno em volta das áreas de texto
    // =============================================================================
    public function __construct($formato = 'A4', $orientacao = 'P', $modo = 'utf-8')
    {
        // criar a instância da classe Mpdf
        $this->pdf = new Mpdf([
            'format' => $formato,
            'orientation' => $orientacao,
            'mode' => $modo
        ]);

        // iniciar o html
        $this->iniciar_html();

        // $this->mostrar_areas = true;
    }

    // =============================================================================
    public function set_template($template)
    {
        $this->pdf->SetDocTemplate($template);
    }

    // =============================================================================
    public function iniciar_html()
    {
        // coloca o html em branco
        $this->html = '';
    }

    // =============================================================================
    public function apresentar_pdf()
    {
        // output para o browser ou para ficheiro pdf
        $this->pdf->WriteHTML($this->html);
        $this->pdf->Output();
    }

    // =============================================================================
    public function nova_pagina()
    {
        // acrescentar uma nova página ao pdf
        $this->html .= '<pagebreak>';
    }


    // =============================================================================
    // métodos para definir posição e dimensao do texto
    // =============================================================================
    
    // =============================================================================
    public function set_x($x)
    {
        $this->x = $x;
    }

    // =============================================================================
    public function set_y($y)
    {
        $this->y = $y;
    }

    // =============================================================================
    public function set_largura($largura)
    {
        $this->largura = $largura;
    }

    // =============================================================================
    public function set_altura($altura)
    {
        $this->altura = $altura;
    }

    // =============================================================================
    public function posicao($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    // =============================================================================
    public function dimensao($largura, $altura)
    {
        $this->largura = $largura;
        $this->altura = $altura;
    }

    // =============================================================================
    public function posicao_dimensao($x, $y, $largura, $altura)
    {
        // define a posição e a dimensão do espaço do texto
        $this->posicao($x, $y);
        $this->dimensao($largura, $altura);
    }

    // =============================================================================
    // cores
    // =============================================================================
    public function set_cor($cor)
    {
        // define a cor do texto
        $this->cor = $cor;
    }

    // =============================================================================
    public function set_cor_fundo($cor)
    {
        // define a cor de fundo
        $this->fundo = $cor;
    }


    // =============================================================================
    // características do texto
    // =============================================================================

    public function set_alinhamento($alinhamento)
    {
        // define o alinhamento do texto dentro do espaço
        $this->alinhamento = $alinhamento;
    }

    // =============================================================================
    public function set_letra_familia($familia){

        $familias_possiveis = [
            'Courier New',
            'Arial',
            'Franklin Gothic Medium',
            'Lucida Sans',
            'Times New Roman',
        ];

        // verificar se $familia pertence ao conjunto de letras permitidas
        if(!in_array($familia, $familias_possiveis)){
            $this->letra_familia = 'Arial';
        } else {
            $this->letra_familia = $familia;
        }
    }

    // =============================================================================
    public function set_letra_tamanho($tamanho)
    {
        $this->letra_tamanho = $tamanho;
    }

    // =============================================================================
    public function set_tipo_letra($tipo)
    {
        $this->letra_tipo = $tipo;
    }
    
    
    // =============================================================================
    public function escrever($texto)
    {
        // escreve texto no documento
        $this->html .= '<div style="';
        
        // posicionamento e dimensão
        $this->html .= 'position: absolute;';
        $this->html .= 'left: ' . $this->x . 'px;';
        $this->html .= 'top: ' . $this->y . 'px;';
        $this->html .= 'width: ' . $this->largura . 'px;';
        $this->html .= 'height: ' . $this->altura . 'px;';

        $this->html .= 'text-align: ' . $this->alinhamento . ';';

        // // cores
        $this->html .= 'color: ' . $this->cor . ';';
        $this->html .= 'background-color: ' . $this->fundo . ';';
        
        // // letra
        $this->html .= 'font-family: ' . $this->letra_familia . ';';
        $this->html .= 'font-size: ' . $this->letra_tamanho . ';';
        $this->html .= 'font-weight: ' . $this->letra_tipo . ';';

        // mostrar contorno da área
        if($this->mostrar_areas){
            $this->html .= 'box-shadow: inset 0px 0px 0px 1px red;';
        }

        $this->html .= '">' . $texto . '</div>';
    }
}