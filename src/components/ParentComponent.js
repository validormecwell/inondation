import React from 'react';
import MapComponent from './MapComponent';


const ParentComponent = () => {
    const [dangerLevel, setDangerLevel] = useState(0); // Exemple d'initialisation avec 0

    return (
        <div>
            <MapComponent dangerLevel={dangerLevel} />
            
        </div>
    );
};

export default ParentComponent;
