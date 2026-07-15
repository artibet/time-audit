import React from 'react';
import { Box, Typography, Button } from '@mui/material';
import InboxOutlinedIcon from '@mui/icons-material/InboxOutlined';

export const EmptyState = ({ onClear }) => {
  return (
    <Box
      sx={{
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        justifyContent: 'center',
        py: 8,
        px: 2,
        border: '1px dashed',
        borderColor: 'divider',
        borderRadius: 2,
        backgroundColor: 'background.paper',
        textAlign: 'center',
      }}
    >
      <InboxOutlinedIcon
        sx={{
          fontSize: 60,
          color: 'text.secondary',
          mb: 2,
          opacity: 0.7
        }}
      />

      <Typography variant="h6" color="text.primary" gutterBottom sx={{ fontWeight: 500 }}>
        Δεν βρέθηκαν δεδομένα
      </Typography>

      <Typography variant="body2" color="text.secondary" sx={{ mb: 3, maxWidth: 350 }}>
        Δεν υπάρχουν καταχωρημένες υπερωρίες για το επιλεγμένο έτος και εύρος μηνών. Δοκιμάστε να αλλάξετε τα φίλτρα αναζήτησης.
      </Typography>

      {onClear && (
        <Button variant="outlined" color="inherit" size="small" onClick={onClear}>
          Επαναφορά Φίλτρων
        </Button>
      )}
    </Box>
  );
};