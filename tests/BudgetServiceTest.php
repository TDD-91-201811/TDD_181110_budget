<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 2018/11/10
 * Time: 下午4:05
 */

use App\IBudgetRepo;
use App\BudgetService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class BudgetServiceTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->budgetService = new BudgetService(new BudgetRepo());
    }

    public function test_should_return_zero_when_this_month_has_no_budget()
    {
        $this->shouldBe(0, '2018-04-01', '2018-04-30');
    }

    public function test_full_one_month_budget()
    {
        $this->shouldBe(310, '2018-05-01', '2018-05-31');
    }

    public function test_range_in_the_same_month()
    {
        $this->shouldBe(100, '2018-05-01', '2018-05-10');
    }

    public function test_across_month()
    {
        $this->shouldBe(30, "2018-05-31", "2018-06-01");
    }

    public function test_across_months()
    {
        $this->shouldBe(1530, "2018-05-01", "2018-07-01");
    }

    public function shouldBe($expected, $startDate, $endDate)
    {
        $this->assertEquals(
            $expected,
            $this->budgetService->totalAmount(
                Carbon::parse($startDate),
                Carbon::parse($endDate)
            )
        );
    }

}

class BudgetRepo implements IBudgetRepo
{
    public function getAll()
    {
        return [
            '2018-04' => 0,
            '2018-05' => 310,
            '2018-06' => 600,
        ];
    }
}
