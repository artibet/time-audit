import { ClientTable } from '@/Components/ClientTable/ClientTable'
import { formatFloat } from '@artibet/react-mui-components/utils'
import { Box, Card, CardContent } from '@mui/material'
import React, { useMemo } from 'react'

export const OvertimesTable = ({ data }) => {

  // ---------------------------------------------------------------------------------------
  // Table columns
  // ---------------------------------------------------------------------------------------
  const columns = useMemo(() => [
    {
      accessorKey: 'am',
      header: 'Α.Μ.',
    },
    {
      accessorKey: 'lastname',
      header: 'Επώνυμο',
    },
    {
      accessorKey: 'firstname',
      header: 'Όνομα',
    },
    {
      accessorKey: 'total_raw_hours',
      header: 'Σύνολο Υπερωριών',
      cell: value => (
        <Box>{formatFloat(value.getValue(), 2)} ώρ.</Box>
      ),
      meta: {
        align: 'right'
      }
    },
    {
      accessorKey: 'total_capped_hours',
      header: 'Δικαιούμενες Υπερωρίες',
      cell: value => (
        <Box>{formatFloat(value.getValue(), 2)} ώρ.</Box>
      ),
      meta: {
        align: 'right'
      }
    },
  ], [data])

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <Card variant="outlined">
      <CardContent>
        <ClientTable
          columns={columns}
          data={data}
          title='Πίνακας Δικαιούχων Υπαλλήλων'
          tableSize='medium'
          enableGlobalFilter={true}
          globalFilterPlaceholder='Αναζήτηση'
          enableColumnFilters={false}
          enableCreateRow={false}
        />
      </CardContent>
    </Card>
  )
}
