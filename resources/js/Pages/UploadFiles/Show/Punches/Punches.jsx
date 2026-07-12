import { DirectionChip } from '@/Components/DirectionChip'
import { ServerSideTable } from '@artibet/react-mui-components/tables'
import { formatDateTime } from '@artibet/react-mui-components/utils'
import { usePage } from '@inertiajs/react'
import { Card, CardContent } from '@mui/material'
import React from 'react'

export const Punches = () => {

  // ---------------------------------------------------------------------------------------
  // State and context
  // ---------------------------------------------------------------------------------------
  const { upload_file } = usePage().props
  const directions = [
    { id: 'Είσοδος', label: 'Είσοδος' },
    { id: 'Έξοδος', label: 'Έξοδος' },
  ]


  // ---------------------------------------------------------------------------------------
  // Table columns
  // ---------------------------------------------------------------------------------------
  const columns = React.useMemo(() => [
    {
      id: 'am',
      label: 'Α.Μ.',
    },
    {
      id: 'lastname',
      label: 'Επώνυμο',
    },
    {
      id: 'firstname',
      label: 'Όνομα',
    },
    {
      id: 'clock_code',
      label: 'Κωδ. Ρολογιού',
    },
    {
      id: 'card_no',
      label: 'Αρ. Κάρτας',
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
      id: 'punched_at',
      label: 'Ημερομηνία/Ώρα',
      render: row => formatDateTime(row.punched_at)
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
          dataUrl={upload_file.url.ssp_punches}
          enableCreateRow={false}
          createButtonTooltip=''
          onCreateRow={() => { }}
          enableGlobalFilter={true}
          enableColumnFilters={true}
          globalFilterPlaceholder='Αναζήτηση'
          rowsClickable={false}
          onRowClick={row => { }}
          keepState={true}
          stateKey={`upload-files-${upload_file.id}-punches`}
        />
      </CardContent>
    </Card>
  )
}
