import React from 'react'
import { Chip } from '@mui/material'

export const DirectionChip = ({ label, color }) => {

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <Chip
      label={label}
      size="small"
      sx={{
        width: 70,
        backgroundColor: `${color}24`,
        color: color,
        fontWeight: 'bold',
        fontSize: '0.75rem',
        border: `1px solid ${color}33`, // 20% opacity border
      }}
    />
  )
}
