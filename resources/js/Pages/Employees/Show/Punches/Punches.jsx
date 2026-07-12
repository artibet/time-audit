import { ServerSideTable } from '@artibet/react-mui-components/tables'
import { usePage } from '@inertiajs/react'
import { Card, CardContent } from '@mui/material'
import React from 'react'
import { DirectionChip } from '../../../../Components/DirectionChip'

export const Punches = () => {

  // ---------------------------------------------------------------------------------------
  // State and context
  // ---------------------------------------------------------------------------------------
  const { employee } = usePage().props
  const directions = [
    { id: 'Είσοδος', label: 'Είσοδος' },
    { id: 'Έξοδος', label: 'Έξοδος' },
  ]
  const months = [
    { id: 'Ιανουάριος', label: 'Ιανουάριος' },
    { id: 'Φεβρουάριος', label: 'Φεβρουάριος' },
    { id: 'Μάρτιος', label: 'Μάρτιος' },
    { id: 'Απρίλιος', label: 'Απρίλιος' },
    { id: 'Μάιος', label: 'Μάιος' },
    { id: 'Ιούνιος', label: 'Ιούνιος' },
    { id: 'Ιούλιος', label: 'Ιούλιος' },
    { id: 'Αύγουστος', label: 'Αύγουστος' },
    { id: 'Σεπτέμβριος', label: 'Σεπτέμβριος' },
    { id: 'Οκτώβριος', label: 'Οκτώβριος' },
    { id: 'Νοέμβριος', label: 'Νοέμβριος' },
    { id: 'Δεκέμβριος', label: 'Δεκέμβριος' },
  ]

  // ---------------------------------------------------------------------------------------
  // Table columns
  // ---------------------------------------------------------------------------------------
  const columns = React.useMemo(() => [
    {
      id: 'punch_year',
      label: 'Έτος',
    },
    {
      id: 'punch_month_name',
      label: 'Μήνας',
      filterType: 'autocomplete',
      filterOptions: months,
      filterValueKey: 'label',
      filterLabel_Key: 'label',
      minWidth: 180,
    },
    {
      id: 'punch_day',
      label: 'Ημέρα',
    },
    {
      id: 'clock_code',
      label: 'Κωδ. Ρολογιού',
    },
    {
      id: 'direction_label',
      label: 'Κατάσταση',
      render: row => <DirectionChip label={row.direction_label} color={row.direction_color} />,
      filterType: 'autocomplete',
      filterOptions: directions,
      filterValueKey: 'label',
      filterLabel_Key: 'label',
      minWidth: 180,
    },
    {
      id: 'punch_time_string',
      label: 'Ώρα',
    },

  ], [])

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <Card variant="outlined" sx={{ marginTop: 0, marginBottom: 0 }}>
      <CardContent>
        <ServerSideTable
          title=''
          columns={columns}
          dataUrl={employee.url.ssp_punches}
          enableCreateRow={false}
          createButtonTooltip=''
          onCreateRow={() => { }}
          enableGlobalFilter={true}
          enableColumnFilters={true}
          globalFilterPlaceholder='Αναζήτηση'
          rowsClickable={false}
          onRowClick={row => { }}
          keepState={true}
          stateKey={`employees-${employee.id}-punches`}
        />
      </CardContent>
    </Card>
  )
}
