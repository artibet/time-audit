import React from 'react'
import { ClientTableContext } from './ClientTable'
import { Typography } from '@mui/material'

export const Title = () => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const { props } = React.useContext(ClientTableContext)

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <Typography variant='h5' sx={props.titleStyle}>{props.title}</Typography>
  )

}
