import React from 'react';
import { Box, Typography } from '@mui/material';
import CalendarMonthIcon from '@mui/icons-material/CalendarMonth';

export const InitialState = () => {
  return (
    <Box
      sx={{
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        justifyContent: 'center',
        py: 10,
        px: 2,
        border: '1px dashed',
        borderColor: 'divider',
        borderRadius: 2,
        backgroundColor: 'background.paper',
        textAlign: 'center',
      }}
    >
      <CalendarMonthIcon
        sx={{
          fontSize: 60,
          color: 'primary.main',
          mb: 2,
          opacity: 0.8
        }}
      />

      <Typography variant="h6" color="text.primary" gutterBottom sx={{ fontWeight: 500 }}>
        Υπολογισμός Υπερωριών Περιόδου
      </Typography>

      <Typography variant="body2" color="text.secondary" sx={{ maxWidth: 400 }}>
        Επιλέξτε το έτος αναφοράς και το εύρος των μηνών παραπάνω, και πατήστε <strong>ΥΠΟΒΟΛΗ</strong> για να εμφανίσετε τα δεδομένα υπερωριών.
      </Typography>
    </Box>
  );
};