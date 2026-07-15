import React from 'react'
import { ClientTableContext } from './ClientTable'
import { Box } from '@mui/material'

export const GlobalActions = () => {

  // ---------------------------------------------------------------------------------------
  // Context data
  // ---------------------------------------------------------------------------------------
  const { props } = React.useContext(ClientTableContext)

  if (!props.globalActions) return null

  return (
    <>
      {
        props.globalActions.map((action, index) => <Box key={index}>{action}</Box>)
      }
    </>
  )
}

