import { Button, Tooltip } from '@mui/material'
import React from 'react'
import { MdOutlineAdd } from 'react-icons/md'
import { ClientTableContext } from './ClientTable'

const CreateButton = () => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const { props } = React.useContext(ClientTableContext)


  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  if (!props.enableCreateRow) return null

  return (
    <Tooltip title={props.createButtonTooltip} arrow={true} placement='top'>
      <Button
        variant={props.createButtonVariant}
        onClick={() => props.onCreateRow()}>
        <MdOutlineAdd size={24} />
      </Button>
    </Tooltip>
  )
}

export default CreateButton