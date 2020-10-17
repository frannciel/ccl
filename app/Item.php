<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Item extends Model
{
    use HasUuid;
    protected $table = 'itens';
    protected $fillable = [
        'numero',  'quantidade', 'codigo', 'objeto', 'descricao', 'unidade_id', 'requisicao_id', 'ordem', 'licitacao_id'
    ];

    /**
     * Auto realcionamento para mesclar itens de duas ou mais requisições
     *
     * @return     <Collect>  App\Item
     */
    public function mesclados()
    {
        return $this->belongsToMany('App\Item', 'mesclados', 'mesclado_id', 'item_id')
        ->withPivot('licitacao_id');
    }
    public function itens()
    {
        return $this->belongsToMany('App\Item', 'mesclados', 'item_id', 'mesclado_id')
        ->withPivot('licitacao_id');
    }

    public function requisicao()
    {
        return $this->belongsTo('App\Requisicao', 'requisicao_id');
    }

    public function licitacao()
    {
        return $this->belongsTo('App\Licitacao', 'licitacao_id');
    }

    /*public function licitacao()
    {
        return $this->belongsToMany('App\Licitacao', 'item_licitacao', 'item_id', 'licitacao_id')->withPivot('ordem');
    }*/

    public function unidade()
    {
        return $this->belongsTo('App\Unidade', 'unidade_id');
    }

    /**
     * @Descrition Método que retorna as Uasg que são participantes do item.
     * 
     * @return <Collect> App\Uasg
     */
    public function participantes()
    {
        return $this->belongsToMany('App\Uasg', 'cidade_uasg', 'item_id', 'uasg_id')
            ->using('App\Participante')
            ->withPivot('cidade_id')
            ->withPivot('quantidade');
    }

    // $item->participantes->first()->pivot->cidade->nome ?? ''

    /**
     * @Descrition Método que retorna as cidades onde os itens deverão ser entregues. 
     * Estás cidades estão relacionadas as unidades participantes e o ógão gereciador.
     * 
     * @return <Collect> App\Cidade
     */
    public function localEntrega(){
        return $this->belongsToMany('App\Cidade', 'cidade_uasg', 'item_id', 'cidade_id')
            ->using('App\Participante')
            ->withPivot('uasg_id')
            ->withPivot('quantidade');
    }

    public function fornecedores()
    {
        return $this->belongsToMany('App\Fornecedor', 'fornecedor_item', 'item_id', 'fornecedor_id')
            ->withPivot('quantidade', 'valor', 'marca', 'modelo' )
            ->withTimestamps();
    }

    public function cotacoes()
    {
        return $this->hasMany('App\Cotacao');
    }

    public function registrosDePrecos()
    {
        return $this->belongsToMany('App\RegistroDePreco', 'item_registro_precos', 'item_id', 'registro_precos_id');
    }

    /**
     * Metódo que retorna os itens da contratação, com a quantidade contratada e o valor unitário atual
     *
     * @return <Collect>  App\Item
     */
    public function cotratacoes()
    {
        return $this->belongsToMany('App\Contratacao', 'contratacao_item', 'contratacao_id', 'item_id')
            ->withPivot(['quantidade', 'valor', 'fornecedor_id']);
    }

    /**
     * Método que retorna a concatenação do ojeto do item com sua descrição detalhada em formato para exibição
     *
     * @return     <type>  The descricao completa attribute.
     */
    public function getDescricaoCompletaAttribute()
    {
        $objeto = $this->objeto != "" ? "<strong>Objeto: </strong>".$this->objeto."<br/><br/><strong>Descrição Detalhada: </strong>": "";
        return $objeto.$this->descricao;
    }

    /**
     * Método que retorna o valor total do item em formato de moeda 0.000,00
     * Este método utiliza o metodo total desta classe
     *
     * @return     <String>  valorTotal
     */
    public function getValorTotalAttribute()
    {
        return number_format($this->total, 2, ',', '.');
    }

    /**
     * Método que retorno o valor total estimado da item em formato numérico
     * Este valor é calculado multiplicando o valor médio das cotações pela quantidade do item
     *
     * @return <Float>  total.
     */
    public function getTotalAttribute()
    {
        return number_format($this->media, 2, '.', '') * $this->quantidade;
    }

     /** 
     *   @Descrition Metodo que retorna o valor médio das cotações formatado na forma de moeda R$ 0.000 0,00
     *
     *   @return <String> valorMédio
     */
    public function getValorMedioAttribute()
    {
        return number_format($this->media, 2, ',', '.');
    }

    /** 
     *   @Descrition Metodo que retorna o valor médio das cotações de preços coletados em formato númerico
     *
     *   @return <Float> valorMedio
     */
    public function getMediaAttribute()
    {
        $cotacoes = $this->cotacoes;
        $tamanho = count($cotacoes);
        $soma  = 0;
        if ($tamanho > 0) {
            foreach ($cotacoes as $cotacao)
                $soma += $cotacao->valor;
            return  $soma / $tamanho;
        } else {
            return 0;
        }
    }

    /**  
     *  @Descrition Metodo que retorna a quantidade total disponível para atribuição de fornecedor
     *  Esta quantidade disponível será calculada subitraindo a quntidade já atribuida ao(s) fornecedor(s)
     *  da quntidade total do item, obitido do método $his->getQuantidadeTotalAttribute.
     *  Método atende a entidade Licitação.
     *
     *  @return <Integer> quantidade disponível
     */
    public function getQuantidadeTotalDisponivelAttribute(){
        $soma = 0;
        foreach ($this->fornecedores as  $fornecedor)
            $soma += $fornecedor->pivot->quantidade;
        return $this->quantidadeTotal - $soma;
    }
    
    /**  
     *  @Descrition Metodo que retorna a quantidade total do item. 
     *  Esta quantidade será calculada somando a quantidade do item com o quantidade de possíveis unidades participantes
     *  Método atende a entidade Licitação.
     *
     *  @return     <Integer> quantidade total
     */
    public function getQuantidadeTotalAttribute(){
        $soma = 0;
        foreach ($this->participantes as $participante)
             $soma += $participante->pivot->quantidade;
        return $soma + $this->quantidade;
    }
}
	