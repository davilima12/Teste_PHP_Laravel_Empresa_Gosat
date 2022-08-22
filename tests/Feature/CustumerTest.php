<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Produto;

class CustumerTest extends TestCase
{
    /**
     * @test
     * 
     */
    public function chekar_colunas_Model_se_estao_corretos()
    {

        $produto = new Produto;
        $arrayEsperado = [
            'nome',
            'fabricante',
            'validade',
            'estoqueAtual',
            'situacao'
        ];
        $arrayComparado = array_diff($produto->getFillable(), $arrayEsperado);
        $this->assertEquals(0, count($arrayComparado));
    }
    /**
     * @test
     */
    public function listar_dados_do_banco_receber_array()
    {
        $response = $this->getJson('/api/produtos');
        $response->assertStatus(200);
    }
    /**
     * @test
     * 
     */

    public function listar_com_filtros_dados_do_banco_receber_array()
    {
        $response = $this->getJson('/api/produtos?filtros=nome:like:%j%;id:<=:4');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function post_inserir_dados_banco_return_json_status_200()
    {
        $response = $this->postJson('/api/produtos', [
            'nome' => 'bolacha recheada',
            'fabricante' => 'mabel',
            'validade' => '2022/01/01',
            'estoqueAtual' => '177',
            'situacao' => 'aprovado',
        ]);
        $response->assertStatus(200)->assertJson([
            'result' => 'Registro Cadastrado Com Sucesso'
        ]);
    }


    /**
     * @test
     */
    public function post_buscar_registro_por_id_receber_array()
    {
        $response = $this->getJson('/api/produtos/11');
        $response->assertStatus(200)->assertJson([
            "id" => 11,
            "nome" => "bolacha recheada",
            "fabricante" => "mabel",
            "validade" => "2022-01-01",
            "estoqueAtual" => 177,
            "situacao" => "aprovado",
            "updated_at" => "2022-08-22T12:04:12.000000Z",
            "created_at" => "2022-08-22T12:04:12.000000Z"
        ]);
    }
    /**
     * @test
     */
    public function editar_registro_por_id_receber_status_200_e_json()
    {
        $response = $this->putJson('/api/produtos/6', [
            'nome' => 'bolacha recheada',
            'fabricante' => 'mabel',
            'validade' => '2022/01/01',
            'estoqueAtual' => '177',
            'situacao' => 'aprovado',
        ]);

        $response->assertStatus(200)->assertJson(['result' => 'Registro Editado Com Sucesso']);
    }

    /**
     * @test
     */
    public function deletar_registros_por_id_json_status_200()
    {
        $response = $this->deleteJson('/api/produtos/12');

        $response->assertStatus(200)->assertJson(['result' => 'Registro Deletado Com Sucesso']);
    }
    /**
     * @test
     */
    public function deletar_testar_se_pode_deletar_registros_nao_enxistentes_respose_json()
    {
        $response = $this->deleteJson('/api/produtos/12');

        $response->assertStatus(404)->assertJson(['error' => 'Não Enxiste Um Registro Com Esse Id']);
    }
}
