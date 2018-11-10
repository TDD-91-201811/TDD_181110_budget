<?php

namespace App;

use Carbon\Carbon;

class BudgetService
{
    /**
     * @var IBudgetRepo
     */
    private $budgetRepo;

    public function __construct(IBudgetRepo $budgetRepo)
    {
        $this->budgetRepo = $budgetRepo;
    }

    public function totalAmount(Carbon $startDate, Carbon $endDate)
    {
        $startMonth = $this->getYearMonth($startDate);
        $endMonth = $this->getYearMonth($endDate);
        if ($startMonth == $endMonth) {
            return $this->totalMonth($startDate, $endDate);
        } else {
            $diffMonth = $this->getMonth($endDate) - $this->getMonth($startDate);
            $total = 0;
            for ($i = 0; $i < $diffMonth; $i++) {
                $firstDate = Carbon::make();
                $secondDate = Carbon::make();



                $total += $this->totalAmount($firstDate,
                        $firstDate->copy()->lastOfMonth()) + $this->totalAmount($secondDate->copy()->firstOfMonth(),
                        $secondDate);
            }


            return $total;
        }

    }

    private function totalMonth(Carbon $startDate, Carbon $endDate)
    {
        $budgets = $this->budgetRepo->getAll();
        $budget = $budgets[$this->getYearMonth($startDate)];
        $thisMonthDays = $startDate->copy()->lastOfMonth()->format("d");
        $dailyBudget = $budget / $thisMonthDays;

        $diff = $startDate->diffInDays($endDate) + 1;
        return $diff * $dailyBudget;
    }

    private function getYearMonth(Carbon $date): string
    {
        return $date->copy()->format('Y-m');
    }

    private function getMonth(Carbon $date): string
    {
        return $date->copy()->format("m");
    }
}
