<?php

class BaseClass
{
    // Define constants for directions
    const DIRECTION_NORTH = 0;
    const DIRECTION_EAST = 90;
    const DIRECTION_SOUTH = 180;
    const DIRECTION_WEST = 270;

    // Define private variables for current position and direction
    private $_currentX;
    private $_currentY;
    private $_currentAngle;
    private $dataBase;

    public function __construct()
    {
        $this->dataBase = new DataBase;
    }

    // Getter for current X 
    public function getCurrentX(): int
    {
        return $this->_currentX;
    }

    // Getter for current Y 
    public function getCurrentY(): int
    {
        return $this->_currentY;
    }
    // Getter for current angle
    public function getcurrentAngle(): int
    {
        return $this->_currentAngle;
    }
    // Setter for current X position
    public function setCurrentX(int $_currentX)
    {
        $this->_currentX = $_currentX;
    }

    // Setter for current Y position
    public function setCurrentY(int $_currentY)
    {
        $this->_currentY = $_currentY;
    }

    // Setter for current angle
    public function setCurrentAngle(int $_currentAngle)
    {
        // if ($_currentAngle >= 0 && $_currentAngle < 270) {
        $this->_currentAngle = $_currentAngle;
        //  return;
        // }
    }


    public function checkTurnRight() : bool
    {
        return true;
    }
    
    public function checkTurnLeft() : bool
    {
        return true;
    }
    // Check if a move is possible
    public function checkMove($_currentX, $_currentY, $_currentAngle, $direction): bool
    {
        $newX = $this->_currentX;
        $newY = $this->_currentY;

        error_log("appel checkmove init x=".$newX." y=".$newY);

        // Calculate new position based on current direction
        switch ($direction) {
            case 0://forward
                switch ($this->getcurrentAngle()) {
                    case 0:
                        $newX++;
                        break;
                    case 90:
                        $newY++;
                        break;
                    case 180:
                        $newX--;
                        break;
                    case 270:
                        $newY--;
                        break;
                    default:
                        break;
                }
                break;
            case 1://left
                switch ($this->getcurrentAngle()) {
                    case 0:
                        $newY++;
                        break;
                    case 90:
                        $newX--;
                        break;
                    case 180:
                        $newY--;
                        break;
                    case 270:
                        $newX++;
                        break;
                    default:
                        break;
                }
                break;
            case 2://right
                switch ($this->getcurrentAngle()) {
                    case 0:
                        $newY--;
                        break;
                    case 90:
                        $newX++;
                        break;
                    case 180:
                        $newY++;
                        break;
                    case 270:
                        $newX--;
                        break;
                    default:
                        break;
                }
                break;
            case 3://backward
                switch ($this->getcurrentAngle()) {
                    case 0:
                        $newX--;
                        break;
                    case 90:
                        $newY--;
                        break;
                    case 180:
                        $newX++;
                        break;
                    case 270:
                        $newY++;
                        break;
                    default:
                        break;
                }

            case 'T.Left':
                switch ($this->getcurrentAngle()) {
                    case 0:
                        $newX++;
                        break;
                    case 90:
                        $newY++;
                        break;
                    case 180:
                        $newX--;
                        break;
                    case 270:
                        $newY--;
                        break;
                    default:
                        break;
                }
                    
            case 'T.Right':
               switch ($this->getcurrentAngle()) {
                    case 0:
                        $newX++;
                        break;
                    case 90:
                        $newY++;
                        break;
                    case 180:
                        $newX--;
                        break;
                    case 270:
                        $newY--;
                        break;
                    default:
                        break;
                }

        }

        error_log("checkmove x=".$newX." y=".$newY." d=".$direction);

        $stmt = $this->dataBase->prepare("SELECT * FROM map WHERE coordx=:currentX AND coordy=:currentY");
        $stmt->execute([':currentX' => $newX, ':currentY' => $newY]);

        return !empty($stmt->fetchAll(PDO::FETCH_OBJ));
    }

    // Move forward
    public function moveForward()
    {
        $newX = $this->getCurrentX();
        $newY = $this->getCurrentY();

        // Calculate new position based on current direction
        // switch ($this->_currentAngle) {
        switch ($this->getcurrentAngle()) {
            case self::DIRECTION_NORTH:
                $newX++;
                break;
            case self::DIRECTION_EAST:
                $newY++;
                break;
            case self::DIRECTION_SOUTH:
                $newX--;
                break;
            case self::DIRECTION_WEST:
                $newY--;
                break;
        }
        $this->setCurrentX($newX);
        $this->setCurrentY($newY);
        return;
    }

    // Turn right
    public function turnRight()
    {
        $this->setCurrentAngle($this->getcurrentAngle() == self::DIRECTION_NORTH ? self::DIRECTION_WEST : $this->getcurrentAngle() - 90);
    }

    // Turn left
    public function turnLeft() 
    {
        $this->setCurrentAngle($this->getcurrentAngle() == self::DIRECTION_WEST ? self::DIRECTION_NORTH : $this->getcurrentAngle() + 90);
    }
    // Move backward
    public function moveBackward()
    {
        $newX = $this->_currentX;
        $newY = $this->_currentY;

        // Calculate new position based on current direction
        switch ($this->getcurrentAngle()) {
            case self::DIRECTION_NORTH:
                $newX--;
              
                break;
            case self::DIRECTION_EAST:
                $newY--;
               
                break;
            case self::DIRECTION_SOUTH:
                $newX++;
                
                break;
            case self::DIRECTION_WEST:
                $newY++;
              
                break;
        }
        $this->setCurrentX($newX);
        $this->setCurrentY($newY);
        return;
        
    }

    // Move to the left

    public function moveLeft()
    {
        $newX = $this->_currentX;
        $newY = $this->_currentY;

        // Calculate new position based on current direction
        switch ($this->getcurrentAngle()) {
            case self::DIRECTION_NORTH:
                $newY++;
                break;
            case self::DIRECTION_EAST:
                $newX--;
                break;
            case self::DIRECTION_SOUTH:
                $newY--;
                break;
            case self::DIRECTION_WEST:
                $newX++;
                break;
        }
        $this->setCurrentX($newX);
        $this->setCurrentY($newY);
        return;
        // $this->_checkMove($newX, $newY, $this->getcurrentAngle());
    }

    // Move to the right

    public function moveRight()
    {
        $newX = $this->_currentX;
        $newY = $this->_currentY;

        // Calculate new position based on current direction
        switch ($this->getcurrentAngle()) {
            case self::DIRECTION_NORTH:
                $newY--;
                break;
            case self::DIRECTION_EAST:
                $newX++;
                break;
            case self::DIRECTION_SOUTH:
                $newY++;
                break;
            case self::DIRECTION_WEST:
                $newX--;
                break;
        }

        $this->setCurrentX($newX);
        $this->setCurrentY($newY);

        // Updated logic to check & perform move
        return;
        // $this->_checkMove($newX, $newY, $this->getcurrentAngle());;
    }
}

  