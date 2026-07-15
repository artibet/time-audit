import React from 'react'
import { IconButton, InputAdornment, TextField } from '@mui/material'
import { MdClear } from 'react-icons/md'

export const TextInput = ({
  initialValue,
  onChange,
  placeholder = '',
  activeColor = '#D4F7F4', //#FFFEA2',
  inactiveColor = 'white',
  clearIcon = true,
}) => {

  // ---------------------------------------------------------------------------------------
  // Local state - keep value
  // ---------------------------------------------------------------------------------------
  const [value, setValue] = React.useState(initialValue)

  // ---------------------------------------------------------------------------------------
  // When initial value changes set to local value
  // ---------------------------------------------------------------------------------------
  React.useEffect(() => {
    setValue(initialValue)
  }, [initialValue])

  const handleChange = e => {
    setValue(e.target.value)
    onChange(e.target.value)
  }

  const handleClear = () => {
    setValue('')
    onChange('')
  }

  return (
    <TextField
      sx={{ backgroundColor: value ? activeColor : inactiveColor }}
      placeholder={placeholder}
      value={value || ''}
      fullWidth={true}
      onChange={handleChange}
      size='small'
      slotProps={{
        input: {
          endAdornment: clearIcon && (
            <InputAdornment position="end" disablePointerEvents={!value}>
              <IconButton onClick={handleClear}>
                {value ? <MdClear /> : <MdClear color="#cccccc" />}
              </IconButton>
            </InputAdornment>
          ),
        },
      }}
    />
  )
}

