<?php /** @noinspection PhpComposerExtensionStubsInspection */

use App\Poi;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PoiControllerTest extends TestCase
{
    use DatabaseTransactions;

    const API_ENDPOINT = '/pois/%s';
    const RELATED_TABLE = 'poi';

    /**
     * @var Poi[]
     */
    private $pois;

    protected function setUp() : void
    {
        parent::setUp();

        $this->pois = [
            factory(Poi::class)->create(),
            factory(Poi::class)->create(),
        ];
    }

    private function getRoute($id = '') : string
    {
        return sprintf(self::API_ENDPOINT, $id);
    }

    public function test_when_getting_base_endpoint_should_return_all_pois()
    {
        // Arrange

        //  Act
        $response = $this->call('GET', $this->getRoute());
        $responseContent = json_decode($response->content(), true);

        // Assert
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertCount(2, $responseContent);
    }

    public function test_when_getting_one_poi_should_return_the_poi_identified_by_the_id()
    {
        // Arrange
        $poi = $this->pois[0];

        // Act
        $response = $this->call('GET', $this->getRoute($poi->id));
        $responseContent = json_decode($response->content(), true);

        // Assert
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertArrayHasKey('id', $responseContent);
        $this->assertEquals($poi->name, $responseContent['name']);
    }

    public function test_when_getting_one_poi_with_invalid_id_should_return_404()
    {
        // Arrange
        // Act
        $response = $this->call('GET', $this->getRoute(0));

        // Assert
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_when_creating_one_poi_with_valid_data_should_create_resource_and_returns_201()
    {
        // Arrange
        $poi = factory(Poi::class)->make([
            'creation_date' => (new DateTime())->format("Y-m-d H:i:s"),
            'last_update' => (new DateTime())->format("Y-m-d H:i:s"),
            'last_update_fme' => (new DateTime())->format("Y-m-d H:i:s"),
        ]);

        // Act
        $response = $this->call('POST', $this->getRoute(), $poi->attributesToArray());

        if ($response->getStatusCode() === 400) {
            $errors = json_decode($response->getContent())->errors;
            echo "\n";
            print_r($errors);
            foreach ($errors as $k => $v) {
                echo "$k : " . $poi->{$k} . "\n";
            }
        }

        // Assert
        $this->assertEquals(201, $response->getStatusCode());
        $this->seeInDatabase(self::RELATED_TABLE, ['id' => $poi->id]);
    }

    public function test_when_creating_poi_with_invalid_data_returns_400_with_detailed_errors()
    {
        // Arrange
        $poi = factory(Poi::class)->make([
            'id' => 'required|integer|unique:poi',
            'zip_code' => 'integer|nullable',
            'email' => 'email|nullable',
            'pricemin' => 'numeric|nullable',
            'pricemax' => 'numeric|nullable',
            'phone' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
            'fax' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
            'fax_phone' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
            'gid' => 'integer|nullable',
            'creation_date' => 'date_format:Y-m-d H:i:s|nullable',
            'last_update' => 'date_format:Y-m-d H:i:s|nullable',
            'last_update_fme' => 'date_format:Y-m-d H:i:s|nullable',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Act
        $response = $this->call('POST', $this->getRoute(), $poi->attributesToArray());
        $responseContent = json_decode($response->content(), true);

        // Assert
        $this->assertEquals($response->getStatusCode(), 400);
        $this->assertCount(14, $responseContent["errors"]);
    }

    public function test_when_deleting_existing_poi_should_delete_the_corresponding_db_entry_and_return_204()
    {
        // Arrange
        $poi = $this->pois[0];

        // Act
        $response = $this->call('DELETE', $this->getRoute($poi->id));
        $tableCount = Poi::count();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals(count($this->pois) - 1, $tableCount);
    }

    public function test_when_updating_an_entry_with_valid_data_should_update_db_and_return_204()
    {
        // Arrange
        $poi = $this->pois[0];
        $poi->name = 'Super Champion';

        // Act
        $response = $this->call('PUT', $this->getRoute($poi->id), $poi->attributesToArray());

        if ($response->getStatusCode() === 400) {
            $errors = json_decode($response->getContent())->errors;
            echo "\n";
            print_r($errors);
            foreach ($errors as $k => $v) {
                echo "$k : " . $poi->{$k} . " : ". gettype($poi->{$k}) . "\n";
            }
        }

        // Assert
        $this->assertEquals(204, $response->getStatusCode());
        $this->seeInDatabase(self::RELATED_TABLE, ['name' => $poi->name]);
    }

    public function test_when_updating_an_invalid_entry_should_return_404()
    {
        // Act
        $response = $this->call('PUT', $this->getRoute(0), []);

        // Assert
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_when_updating_an_entry_with_invalid_data_should_return_400_with_detailed_error()
    {
        // Arrange
        $poi = $this->pois[0];
        $poi->zip_code = 'integer|nullable';
        $poi->email = 'email|nullable';
        $poi->pricemin = 'numeric|nullable';
        $poi->pricemax = 'numeric|nullable';
        $poi->phone = 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable';
        $poi->fax = 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable';
        $poi->fax_phone = 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable';
        $poi->gid = 'integer|nullable';
        $poi->latitude = 'required|numeric';
        $poi->longitude = 'required|numeric';

        // Act
        $response = $this->call('PUT', $this->getRoute($poi->id), $poi->attributesToArray());
        $responseContent = json_decode($response->content(), true);

        // Assert
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertCount(10, $responseContent["errors"]);
    }
}
