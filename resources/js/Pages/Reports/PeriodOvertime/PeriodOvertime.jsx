import React, { useState } from 'react'
import { AuthLayout } from '@/Layouts/AuthLayout'
import { Typography } from '@mui/material'
import { FilterForm } from './FilterForm'
import { OvertimesTable } from './OvertimesTable'
import { EmptyState } from './EmptyState'
import { InitialState } from './InitialState'
import { router } from '@inertiajs/react'

const PeriodOvertime = ({ years, months, report = [], filters }) => {

  // ---------------------------------------------------------------------------------------
  // State and context
  // ---------------------------------------------------------------------------------------
  const [isLoading, setIsLoading] = useState(false)
  const hasFiltersApplied = filters != null && filters.year !== null && filters.month_from !== null && filters.month_to !== null;

  // ---------------------------------------------------------------------------------------
  // Form submit handler
  // ---------------------------------------------------------------------------------------
  const handleSubmit = data => {
    setIsLoading(true)
    router.visit('/reports/period-overtimes', {
      method: 'get',
      data: {
        year: data.year,
        month_from: data.month_from,
        month_to: data.month_to
      },
      replace: true,         // Replaces the URL in the history stack
      preserveState: true,   // Keeps the react-hook-form state intact
      onFinish: () => setIsLoading(false)
    });
  }

  // ---------------------------------------------------------------------------------------
  // Reset handler
  // ---------------------------------------------------------------------------------------
  const handleReset = () => {
    setIsLoading(true)
    router.visit('/reports/period-overtimes', {
      method: 'get',
      data: {},              // Clears the query parameters from the URL
      replace: true,         // Replaces the URL in the history stack
      preserveState: false,  // Discards the component state to load clean defaults
      onFinish: () => setIsLoading(false)
    });
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <>
      <Typography variant="h5" sx={{ mb: 4 }}>
        Υπερωρίες Περιόδου
      </Typography>
      <FilterForm
        onSubmit={handleSubmit}
        onReset={handleReset}
        years={years}
        months={months}
        filters={filters}
        isLoading={isLoading}
      />

      {/* Conditionally render the body */}
      {!hasFiltersApplied ? (
        // 1. No filter given yet
        <InitialState />
      ) : report.length > 0 ? (
        // 2. Results found
        <OvertimesTable data={report} />
      ) : (
        // 3. Filters applied, but 0 results
        <EmptyState />
      )}
    </>
  )
}

// Layout and export
PeriodOvertime.layout = page => <AuthLayout children={page} title="Αναφορές - Υπερωρίες" />
export default PeriodOvertime